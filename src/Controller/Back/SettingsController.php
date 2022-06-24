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

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['imageFile']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/img';
            $newFilename = 'banner.'.$uploadedFile->guessExtension();

            $uploadedFile->move(
                $destination,
                $newFilename
            );

            return $this->renderForm('Back/settings/index.html.twig', [
                'controller_name' => 'SettingsController',
                'form' => $form,
            ]);
        }

        return $this->renderForm('Back/settings/index.html.twig', [
            'controller_name' => 'SettingsController',
            'form' => $form,
        ]);
    }
}
