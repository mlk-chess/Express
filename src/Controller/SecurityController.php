<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\TrainCompanyType;
use App\Form\UserType;
use App\Service\ApiMailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /* Create company */
    #[Route('/register-company', name: 'app_register_company', methods: ['GET', 'POST'])]
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
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
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
                        "username" => $user->getEmail(),
                        "userid" => $user->getId(),
                        "token" => $token,
                    ]
                );

                $mailer->send($email);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
            } else foreach ($list_err as $err) $this->addFlash('red', $err);
        }

        return $this->renderForm('security/register.html.twig', [
        'train' => $user,
        'form' => $form,
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
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
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
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
                        "username" => $user->getEmail(),
                        "userid" => $user->getId(),
                        "token" => $token,
                    ]
                );

                $mailer->send($email);
            }

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/register.html.twig', [
            'train' => $user,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, ManagerRegistry $doctrine): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
            ]
        );
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
