<?php

namespace App\Controller\Front;

use App\Form\UserPwdType;
use App\Form\UserType;
use App\Form\WagonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserController extends AbstractController
{
    #[Route('/profile', name: 'user_index', methods: ['GET','POST'])]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(UserType::class, $userConnected);
        $form->handleRequest($request);

        $formPwd = $this->createForm(UserPwdType::class, $userConnected);
        $formPwd->handleRequest($request);
        $data = $formPwd->getData();


        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('green', "Les information du profile ont bien été modifié");
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);

        }else if($formPwd->isSubmitted() && $formPwd->isValid()){
            $data->setPassword($passwordHasher->hashPassword($data,$data->getPlainPassword()));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('green', "Le mot de passe a bien été modifié");
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/user/profile.html.twig', [
            'user' => $userConnected,
            'form' => $form,
            'formPwd' => $formPwd
        ]);
    }
}
