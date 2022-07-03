<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SettingsType;

#[Route('/admin')]
class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(SettingsType::class);
        $form->handleRequest($request);

        $banner = 'png';

        if (file_exists('./img/banner.png')) {
            $banner = 'png';
        }elseif (file_exists('./img/banner.jpg')) {
            $banner = 'jpg';
        }

            if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['imageFile']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/img';
            $extension = strtolower($uploadedFile->guessExtension());
            $newFilename = 'banner.'.$extension;

            if ($extension === 'png' || $extension =='jpg') {
                if (file_exists('./img/banner.jpg') && $extension === 'png') {
                    unlink('./img/banner.jpg');
                }elseif (file_exists('./img/banner.png') && $extension === 'jpg') {
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
                    'error' => false
                ]);
            }

            return $this->renderForm('Back/settings/index.html.twig', [
                'controller_name' => 'SettingsController',
                'form' => $form,
                'banner' => $banner,
                'error' => true
            ]);
        }

        return $this->renderForm('Back/settings/index.html.twig', [
            'controller_name' => 'SettingsController',
            'form' => $form,
            'banner' => $banner,
            'error' => false
        ]);
    }
}
