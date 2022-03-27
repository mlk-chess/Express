<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Service\ApiMailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    #[Route('/account-validation/{id}/{token}', name: 'account_validation')]
    public function validation(ManagerRegistry $doctrine, int $id, string $token, MailerInterface $mailer): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (empty($user->getToken())) {
            return new Response("Erreur lors de la validation de l'e-mail, il est possible que vous ayez déjà validé votre compte...");
        }

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
        }else return new Response("Erreur lors de la validation de l'e-mail");

        if (in_array("COMPANY", $user->getRoles()))
            return new Response("Votre e-mail a été validé, vous devez attendre que l'administrateur du site confirme votre inscription, vous recevrez un mail. (Cela peut prendre de 24h à 48h)");
        else
            return new Response("Votre e-mail a été validé");

    }

}