<?php

namespace App\Controller\Back;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use App\Repository\UserRepository;
use App\Service\ApiMailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/newsletter')]
class NewsletterController extends AbstractController
{
    #[Route('/', name: 'app_newsletter_index', methods: ['GET'])]
    public function index(NewsletterRepository $newsletterRepository, UserRepository $userRepository): Response
    {
        return $this->render('Back/newsletter/index.html.twig', [
            'newsletters' => $newsletterRepository->findAll(),
            'users' => $userRepository->findBy(["newsletter" => 1]),
        ]);
    }

    #[Route('/new', name: 'app_newsletter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NewsletterRepository $newsletterRepository, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $userRepository->findBy(['newsletter' => 1]);
            $newsletterRepository->add($newsletter);
            $msg = $newsletter->getMessage();

            foreach ($users as $user) {
                $email = ApiMailerService::send_email_newsletter(
                    $user->getEmail(),
                    "[Express] Newsletter #".$newsletter->getId(),
                    "newsletter.html.twig",
                    [
                        'message' => $newsletter->getMessage()
                    ]
                );

                $mailer->send($email);
            }

            return $this->redirectToRoute('app_newsletter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/newsletter/new.html.twig', [
            'newsletter' => $newsletter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_newsletter_show', methods: ['GET'])]
    public function show(Newsletter $newsletter): Response
    {
        return $this->render('Back/newsletter/show.html.twig', [
            'newsletter' => $newsletter,
        ]);
    }
    #[Route('/{id}', name: 'app_newsletter_delete', methods: ['POST'])]
    public function delete(Request $request, Newsletter $newsletter, NewsletterRepository $newsletterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newsletter->getId(), $request->request->get('_token'))) {
            $newsletterRepository->remove($newsletter);
        }

        return $this->redirectToRoute('app_newsletter_index', [], Response::HTTP_SEE_OTHER);
    }
}
