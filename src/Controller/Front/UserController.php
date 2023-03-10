<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Entity\User as AppUser;
use App\Form\ProfileType;
use App\Service\ApiMailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserPwdType;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;


class UserController extends AbstractController
{
    #[Route('/account-validation/{id}/{token}', name: 'account_validation')]
    public function validation(ManagerRegistry $doctrine, int $id, string $token, MailerInterface $mailer): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if(empty($user)) throw new \Exception("Erreur...");

        if (empty($user->getToken()))
            throw new \Exception("Erreur...");


        if ($user->getToken() === $token) {
            $user->setStatus(1);
            $user->setToken(NULL);
            $entityManager->flush();
            $email = ApiMailerService::send_email(
                $user->getEmail(),
                "Bienvenue sur express",
                "success-validation.html.twig",
                [
                    "username" => $user->getEmail(),
                ]
            );
            $mailer->send($email);
        } else throw new \Exception("Erreur...");


        if (in_array("ROLE_COMPANY", $user->getRoles()))
            return new Response("Votre e-mail a été validé, vous devez attendre que l'administrateur du site confirme votre inscription, vous recevrez un mail. (Cela peut prendre de 24h à 48h)");
        else
            return new Response("Votre e-mail a été validé");

    }

    #[Route('/profile', name: 'user_index', methods: ['GET', 'POST'])]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(ProfileType::class, $userConnected);
        $form->handleRequest($request);

        $formPwd = $this->createForm(UserPwdType::class, $userConnected);
        $formPwd->handleRequest($request);
        $data = $formPwd->getData();


        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('green', "Les information du profile ont bien été modifié");

            $email = ApiMailerService::send_email(
                $userConnected->getEmail(),
                "[PA Express] Vos informations ont été modifiée",
                "change-information-profile.html.twig",
                [
                    "username" => $userConnected->getEmail(),
                ]
            );
            $mailer->send($email);

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);

        } else if ($formPwd->isSubmitted() && $formPwd->isValid()) {
            if (strlen($data->getPlainPassword()) >= 6){
                $data->setPassword($passwordHasher->hashPassword($data, $data->getPlainPassword()));
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('green', "Le mot de passe a bien été modifié");
                $email = ApiMailerService::send_email(
                    $userConnected->getEmail(),
                    "[PA Express] Votre mot de passe a été modifié !",
                    "change-pwd-profile.html.twig",
                    [
                        "username" => $userConnected->getEmail(),
                    ]
                );
                $mailer->send($email);

            }else{
                return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
            }


            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/user/profile.html.twig', [
            'user' => $userConnected,
            'form' => $form,
            'formPwd' => $formPwd
        ]);
    }
}
