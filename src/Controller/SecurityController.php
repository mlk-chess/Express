<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\TrainCompanyType;
use App\Form\UserType;
use App\Service\Helper;
use App\Service\ApiMailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /* Create company */
    #[Route('/register-company', name: 'app_register_company', methods: ['GET', 'POST'])]
    public function new_train_company(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $user->setRoles(['COMPANY']);
        $user->setToken($token);
        $form = $this->createForm(TrainCompanyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
                    "password" => null
                ]
            );

            $mailer->send($email);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/register.html.twig', [
            'train' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        if ($this->security->getUser()) {
            return $this->redirectToRoute('home', [], 301);
        }

        $user = new User();
        $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $user->setToken($token);
        $user->setRoles(['USER']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPlainPassword($user->getPassword());
            $user->setStatus(0);

            $user->setRoles(["ROLE_CUSTOMER"]);
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
                    "password" => null
                ]
            );

            $mailer->send($email);


            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/register.html.twig', [
            'train' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils, ManagerRegistry $doctrine): Response
    {
        if ($this->security->getUser()) {
            return $this->redirectToRoute('home', [], 301);
        }

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

    #[Route('/logout', name: 'app_logout', methods: ['GET', 'POST'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}