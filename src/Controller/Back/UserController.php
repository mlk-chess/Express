<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\TrainCompanyType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Service\ApiMailerService;

#[Route('/admin/user')]
class UserController extends AbstractController
{

    /* Client */
    #[Route('/', name: 'admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('Back/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /* Create company */
    #[Route('/new-company', name: 'admin_user_company_new', methods: ['GET', 'POST'])]
    public function new_train_company(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $user->setRoles(['COMPANY']);
        $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $user->setToken($token);
        $form = $this->createForm(TrainCompanyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ((strlen($user->getCompanyName()) < 2 || strlen($user->getCompanyName()) > 50))
                $list_err[] = 'Le nom de la société doit être une chaine de caractère compris entre 2 et 50 caractères';
            if (strlen($user->getPassword()) < 6 || strlen($user->getPassword()) > 50)
                $list_err[] = 'Le mot de passe doit faire entre 6 et 50 caractères';

            if (empty($list_err)) {
                $user->setPlainPassword($user->getPassword());
                $user->setStatus(0);


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $email = ApiMailerService::send_email(
                    $user->getEmail(),
                    "Validation de votre compte",
                    "signup.html.twig",
                    [
                        'expiration_date' => new \DateTime('+7 days'),
                        "username" => $user->getCompanyName() ?? $user->getEmail(),
                        "userid" => $user->getId(),
                        "token" => $token,
                    ]
                );

                $mailer->send($email);

                return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
            } else foreach ($list_err as $err) $this->addFlash('red', $err);
        }

        return $this->renderForm('Back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/new-user', name: 'admin_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $user->setToken($token);
        $user->setRoles(['USER']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (strlen($user->getPassword()) < 6 || strlen($user->getPassword()) > 50)
                $list_err[] = 'Le mot de passe doit faire entre 6 et 50 caractères';

            if (empty($list_err)) {
                $user->setPlainPassword($user->getPassword());
                $user->setStatus(0);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $email = ApiMailerService::send_email(
                    $user->getEmail(),
                    "Validation de votre compte",
                    "signup.html.twig",
                    [
                        'expiration_date' => new \DateTime('+7 days'),
                        "username" => $user->getCompanyName() ?? $user->getEmail(),
                        "userid" => $user->getId(),
                        "token" => $token,
                    ]
                );

                $mailer->send($email);
            }

            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('Back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit-train-company', name: 'admin_user_edit_company', methods: ['GET', 'POST'])]
    public function edit_train_company(Request $request, User $user): Response
    {
        $form = $this->createForm(TrainCompanyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
    }

}
