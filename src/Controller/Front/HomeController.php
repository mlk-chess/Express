<?php

namespace App\Controller\Front;

use App\Entity\LineTrain;
use App\Form\HomeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            $repository = $entityManager->getRepository(LineTrain::class);

            $query = $repository->createQueryBuilder('lt')
                ->select('lt, l')
                ->leftJoin('lt.line', 'l')
                ->andWhere('l.name_station_departure = :station_departure')
                ->andWhere('l.name_station_arrival = :station_arrival')
                ->setParameters([
                    'station_departure'=> $form->get('departureStationInput')->getData(),
                    'station_arrival'=> $form->get('arrivalStationInput')->getData()
                ]);

//            $travel = $repository->find(1);


            $q = $query->getQuery();

            $travels = $q->execute();
            dd($travels);

            return $this->renderForm('Front/home/index.html.twig', [
                'controller_name' => 'HomeController',
                'form' => $form,
                'travels' => $travels
            ]);
        }

        return $this->renderForm('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form,
            'travels' => false
        ]);
    }

    #[Route('/stations', name: 'stations')]
    public function getStations(): Response
    {
        $json = file_get_contents("../templates/Front/home/stations.json");
        return new Response($json);
    }
}
