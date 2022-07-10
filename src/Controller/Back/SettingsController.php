<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SettingsType;
use App\Form\UserPwdType;
use App\Service\ApiMailerService;


#[Route('/admin')]
class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(SettingsType::class);
        $form->handleRequest($request);

        $formPwd = $this->createForm(UserPwdType::class, $userConnected);
        $formPwd->handleRequest($request);
        $data = $formPwd->getData();

        $banner = 'png';

        if (file_exists('./img/banner.png')) {
            $banner = 'png';
        } elseif (file_exists('./img/banner.jpg')) {
            $banner = 'jpg';
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['imageFile']->getData();
            $destination = $this->getParameter('kernel.project_dir') . '/public/img';
            $extension = strtolower($uploadedFile->guessExtension());
            $newFilename = 'banner.' . $extension;

            if ($extension === 'png' || $extension == 'jpg') {
                if (file_exists('./img/banner.jpg') && $extension === 'png') {
                    unlink('./img/banner.jpg');
                } elseif (file_exists('./img/banner.png') && $extension === 'jpg') {
                    unlink('./img/banner.png');
                }

                $uploadedFile->move(
                    $destination,
                    $newFilename
                );

                $banner = $extension;

                return $this->renderForm('Back/settings/index.html.twig', [
                    'controller_name' => 'SettingsController',
                    'form' => $form,
                    'banner' => $banner,
                    'error' => false,
                    'formPwd' => $formPwd
                ]);
            }

            return $this->renderForm('Back/settings/index.html.twig', [
                'controller_name' => 'SettingsController',
                'form' => $form,
                'banner' => $banner,
                'error' => true,
                'formPwd' => $formPwd
            ]);
        }

        if ($formPwd->isSubmitted() && $formPwd->isValid()) {
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

            return $this->redirectToRoute('app_settings', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/settings/index.html.twig', [
            'controller_name' => 'SettingsController',
            'form' => $form,
            'banner' => $banner,
            'error' => false,
            'formPwd' => $formPwd
        ]);
    }
}
