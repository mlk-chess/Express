<?php

namespace App\Controller\Front;

use App\Entity\LineTrain;
use App\Entity\Option;
use App\Form\HomeType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/home')]
class HomeController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $session = $this->requestStack->getSession();
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(HomeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('departureStationInput')->getData() == null || $form->get('arrivalStationInput')->getData() == null) {
                $this->addFlash('red', "La gare de départ et la gare d'arrivée doivent être remplis");

                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            }

            $date = new DateTime($form->get('date')->getData()->format('d-m-Y'));
            $time = new DateTime($form->get('time')->getData()->format('H:i:s'));
            $date->setTime($time->format('H'), $time->format('i'), $time->format('s'));

            if ($date->format('d-m-Y H:i:s') <= date('d-m-Y H:i:s', time())) {
                $this->addFlash('red', "La date et l'heure ne sont pas valides");

                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(LineTrain::class);


            $query = $repository->createQueryBuilder('lt')
                ->select('lt, line')
                ->leftJoin('lt.line', 'line')
                ->where('line.name_station_departure = :station_departure')
                ->andWhere('line.name_station_arrival = :station_arrival')
                ->andWhere('lt.date_departure = :date_departure')
                ->andWhere('lt.time_departure >= :time_departure')
                ->setParameters([
                    'station_departure' => $form->get('departureStationInput')->getData(),
                    'station_arrival' => $form->get('arrivalStationInput')->getData(),
                    'date_departure' => $form->get('date')->getData()->format('Y-m-d'),
                    'time_departure' => $form->get('time')->getData()->format('H:i:s')
                ]);


            $q = $query->getQuery();

            $travels = $q->execute();

            if (count($travels) === 0) {
                $noTravels = true;
            } else {
                $noTravels = false;
            }

            return $this->renderForm('Front/home/index.html.twig', [
                'controller_name' => 'HomeController',
                'form' => $form,
                'travels' => $travels,
                'noTravels' => $noTravels
            ]);

        }

        return $this->renderForm('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form,
            'travels' => false,
            'noTravels' => false
        ]);
    }

    #[Route('/shopping', name: 'shopping')]
    public function shopping(Request $request): Response
    {
        $session = $this->requestStack->getSession();
        $dataSession = $session->get('shopping');

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(LineTrain::class);

        $travels = [];

        foreach ($dataSession as $key => $value) {
            $query = $repository->createQueryBuilder('lt')
                ->select('lt, line')
                ->leftJoin('lt.line', 'line')
                ->where('lt.id = :id')
                ->setParameters([
                    'id' => $value[0]
                ]);

            $q = $query->getQuery();

            $travel = $q->execute();
            array_push($travels, [$travel[0], $value[1]]);
        }
        
        return $this->renderForm('Front/home/shopping.html.twig', [
            'controller_name' => 'HomeController',
            'travels' => $travels
        ]);
    }

    #[Route('/stations', name: 'stations')]
    public function getStations(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $json = file_get_contents("../templates/Front/home/stations.json");
            return new JsonResponse($json);
        }
        return new JsonResponse(false);
    }

    #[Route('/add-option', name: 'addOption')]
    public function addOption(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $id = intval($request->request->get('id'));
            $classWagon = intval($request->request->get('classWagon'));

            $session = $this->requestStack->getSession();
            $dataSession = $session->get('shopping');

            if ($dataSession === null){
                $session->set('shopping', [[$id, $classWagon]]);
            } else {
                array_push($dataSession, [$id, $classWagon]);
                $session->set('shopping', $dataSession);
            }

            return new JsonResponse($session->get('shopping'));
        }
        return new JsonResponse(false);
    }
}
