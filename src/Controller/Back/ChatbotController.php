<?php

namespace App\Controller\Back;

use App\Entity\Chatbot;
use App\Entity\User;
use App\Form\ChatbotStatusType;
use App\Service\ApiMailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class ChatbotController extends AbstractController
{

    #[Route('/chatbot', name: 'app_chatbot_admin')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $messages = $em->getRepository(Chatbot::class)->findAll();
        return $this->render('Back/chatbot/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit-status-chatbot', name: 'admin_chatbot_edit_status', methods: ['GET', 'POST'])]
    public function editStatus(Request $request, Chatbot $chatbot, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ChatbotStatusType::class, $chatbot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(["email" => $chatbot->getClientEmail()]);
            $this->getDoctrine()->getManager()->flush();

            $email = ApiMailerService::send_email(
                $user->getEmail(),
                "MorphyBot - Mise à jour de votre demande",
                "admin-change-status-chatbot.html.twig",
                [
                    'expiration_date' => new \DateTime('+7 days'),
                    "username" => $chatbot->getClientName(),
                ]
            );

            $mailer->send($email);

            return $this->redirectToRoute('app_chatbot_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/chatbot/edit-chatbot.html.twig', [
            'form' => $form,
        ]);
    }
}
