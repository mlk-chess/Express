<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\TrainCompanyType;
use App\Form\TrainCompanyAdminType;
use App\Form\UserType;
use App\Form\UserAdminType;
use App\Form\UserStatusType;
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
        $form = $this->createForm(TrainCompanyAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $password = rtrim(strtr(base64_encode(random_bytes(16)), '+/', '-_'), '=');
                $user->setPlainPassword($password);
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
                        "password" => $password,
                        "userid" => $user->getId(),
                        "token" => $token,
                    ]
                );

                $mailer->send($email);

                return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
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
        $form = $this->createForm(UserAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $password = rtrim(strtr(base64_encode(random_bytes(16)), '+/', '-_'), '=');
                $user->setPlainPassword($password);
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
                        "password" => $password,
                        "token" => $token,
                    ]
                );

                $mailer->send($email);

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
        $form = $this->createForm(TrainCompanyAdminType::class, $user);
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
        $form = $this->createForm(UserAdminType::class, $user);
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

    #[Route('/{id}/edit-status', name: 'admin_user_edit_status', methods: ['GET', 'POST'])]
    public function editStatus(Request $request, User $user, MailerInterface $mailer): Response
    {
        $form = $this->createForm(UserStatusType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->getStatus() !== 0 ? $object = "Express - Validation de votre compte" : $object = "Express - Désactivation de votre compte";
            $this->getDoctrine()->getManager()->flush();

            $email = ApiMailerService::send_email(
                $user->getEmail(),
                $object,
                "admin-change-status.html.twig",
                [
                    'expiration_date' => new \DateTime('+7 days'),
                    "username" => $user->getCompanyName() ?? $user->getEmail(),
                    'status' => $user->getStatus()
                ]
            );

            $mailer->send($email);

            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
