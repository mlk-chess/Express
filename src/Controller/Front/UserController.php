<?php

namespace App\Controller\Front;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;


class UserController extends AbstractController
{
    #[Route('/account-validation/{id}/{token}', name: 'account_validation')]
    public function validation(ManagerRegistry $doctrine, int $id, string $token): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if ($user->getToken() === $token) {
           if(in_array("USER", $user->getRoles()))
           {
               $user->setStatus(1);
               $entityManager->flush();
           }
           else if(in_array("USER", $user->getRoles())) {
               $user->setStatus(2);
               $entityManager->flush();
           }
        }else dd("Erreur de validation");

        return $this->redirectToRoute('app_login', [], 201);
    }

}