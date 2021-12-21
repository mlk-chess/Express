<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/stations', name: 'stations')]
    public function getStations(): Response
    {
        $json = file_get_contents("../templates/Front/home/stations.json");
        return new Response($json);
    }
}
