<?php

namespace App\Controller\Front;

use App\Form\HomeType;
use App\Form\TrainType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {

        $form = $this->createForm(HomeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
        }

        return $this->renderForm('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form
        ]);
    }

    #[Route('/stations', name: 'stations')]
    public function getStations(): Response
    {
        $json = file_get_contents("../templates/Front/home/stations.json");
        return new Response($json);
    }
}
