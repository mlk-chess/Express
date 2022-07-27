<?php

namespace App\Controller\Back;

use App\Entity\BookingSeat;
use App\Entity\LineTrain;
use App\Entity\Train;
use App\Form\LineTrainType;
use App\Repository\BookingRepository;
use App\Repository\BookingSeatRepository;
use App\Repository\LineRepository;
use App\Repository\LineTrainRepository;
use App\Repository\SeatRepository;
use App\Repository\TrainRepository;
use App\Service\Helper;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/line-train')]
class LineTrainController extends AbstractController
{
    #[Route('/', name: 'line_train_index', methods: ['GET'])]
    public function index(LineTrainRepository $lineTrainRepository): Response
    {

        $userConnected = $this->get('security.token_storage')->getToken()->getUser();
        if (in_array('ROLE_COMPANY', $userConnected->getRoles())){
            return $this->render('Back/line_train/index.html.twig', [
                'line_trains' => $lineTrainRepository->findLineTrainCompany($userConnected->getId()),
                ]);
        }else{
            return $this->render('Back/line_train/index.html.twig', [
                'line_trains' => $lineTrainRepository->findAll(),
            ]);
        }

        
    }

    #[Route('/planning', name: 'line_train_planning', methods: ['GET'])]
    public function planning(LineTrainRepository $lineTrainRepository): Response
    {

        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if (in_array('ROLE_COMPANY', $userConnected->getRoles())){
            $getTravels = $lineTrainRepository->findLineTrainByDate($userConnected->getId());
        }else{
            $getTravels = $lineTrainRepository->findLineTrainByDate();
        }

        $travels = [];

        foreach ($getTravels as $travel) {
            $travels[] = [
                'title' => $travel["nb"] . " départ(s) prévu(s)",
                'start' => $travel["date_departure"]->format('Y-m-d'),
                'display' => "background",
            ];
        }

        $data = json_encode($travels);

        return $this->render('Back/line_train/planning.html.twig', [
            'data' => $data
        ]);
    }

    #[IsGranted('ROLE_COMPANY')]
    #[Route('/new', name: 'line_train_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LineTrainRepository $lineTrainRepository, TrainRepository $trainRepository, LineRepository $lineRepository): Response
    {

        $errors = [];
        $success = [];
        $lineTrain = new LineTrain();
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();
        $train = $trainRepository->findBy(["status" => 1,"owner"=> $userConnected->getId()]);
        $line = $lineRepository->findBy(["status" => 1]);
        $form = $this->createForm(LineTrainType::class, $lineTrain, ["train" => $train, "line" => $line]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lonDeparture = $lineTrain->getLine()->getLongitudeDeparture();
            $latDeparture = $lineTrain->getLine()->getLatitudeDeparture();
            $lonArrival = $lineTrain->getLine()->getLongitudeArrival();
            $latArrival = $lineTrain->getLine()->getLatitudeArrival();
            $placeNbclass1 = 0;
            $placeNbclass2 = 0;
            $isBetween = false;


            $getWagonByTrain = $lineTrainRepository->findWagonByTrain($lineTrain->getTrain()->getId());

            if (empty($getWagonByTrain)) {
                $errors[] = "Ce train n'a pas de wagon !";
            } else {
                foreach ($getWagonByTrain as $wagon) {
                  
                    if ($wagon['type'] == "Voyageur" && $wagon['status'] == 1) {
                        if ($wagon['class'] == 1) {
                            $placeNbclass1 += $wagon['placeNb'];
                        } else {
                            $placeNbclass2 += $wagon['placeNb'];
                        }
                    }
                }

                $lineTrain->setPlaceNbClass1($placeNbclass1);
                $lineTrain->setPlaceNbClass2($placeNbclass2);
            }



            $date = new DateTime($lineTrain->getDateDeparture()->format('Y-m-d') . " " . $lineTrain->getTimeDeparture()->format('H:i:s'));
            $date = $date->format('Y-m-d H:i:s');

            if ($date < date('Y-m-d H:i:s')) {
                $errors[] = "La date de départ ne peut pas être inférieur à celle d'aujourd'hui !";
            }

            $distance = Helper::distance($latDeparture, $lonDeparture, $latArrival, $lonArrival, "K");

            $getTime = ($distance * 60) / 300;
            $getTime = round($getTime * 3600 / 60);

            $dateTimeArrival = date("Y-m-d H:i:s", strtotime("$date +$getTime seconds"));

            $lineTrain->setDateArrival(new DateTime($dateTimeArrival));
            $lineTrain->setTimeArrival(new DateTime($dateTimeArrival));


            $getTrainByDate = $lineTrainRepository->findTrainByDate($lineTrain->getTrain()->getId());

            if ($getTrainByDate) {

                foreach ($getTrainByDate as $value) {

                    if (($date >= $value["timestampdeparture"] && $date <= $value["timestamparrival"]) || ($dateTimeArrival >= $value["timestampdeparture"] && $date <= $value["timestamparrival"])) {
                        $isBetween = true;
                    }
                }
            }

            if ($lineTrain->getPriceClass1() < 1 || $lineTrain->getPriceClass2() < 1 ){
                $errors[] = "Le prix ne peut pas être inférieur à 1€ !";
            }

            if ($isBetween) $errors[] = "Le train est indisponible à cette date !";

            if ($lineTrain->getDateDeparture() > $lineTrain->getDateArrival()) {
                $errors[] = "La date de départ ne peut pas être supérieur à la date d'arrivée";
            }

            if ($lineTrain->getDateDeparture() == $lineTrain->getDateArrival()) {

                if ($lineTrain->getTimeDeparture()->format('H-i-s') < date('H-i-s')) {
                    $errors[] = "Erreur horaire de départ !";
                }
                if ($lineTrain->getTimeDeparture() >= $lineTrain->getTimeArrival()) {
                    $errors[] = "L'horaire de départ ne peut pas être supérieur à l'horaire d'arrivée";
                }
            }

            if (empty($errors)) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($lineTrain);
                $entityManager->flush();

                $success[] = "Le voyage a bien été créé !";
              
                //return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
            } else {
                
                return $this->renderForm('Back/line_train/new.html.twig', [
                    'line_train' => $lineTrain,
                    'form' => $form,
                    'errors' => $errors,
                    'success' => $success
                ]);
            }
        }

        return $this->renderForm('Back/line_train/new.html.twig', [
            'line_train' => $lineTrain,
            'form' => $form,
            'errors' => $errors,
            'success' => $success
        ]);
    }

    #[Route('/{id}', name: 'line_train_show', methods: ['GET'])]
    public function show(LineTrain $lineTrain, LineTrainRepository $lineTrainRepository, int $id): Response
    {   
        $travel = $lineTrainRepository->find($id);
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if ( $userConnected->getId() != $travel->getTrain()->getOwner()->getId() && in_array('ROLE_COMPANY', $userConnected->getRoles()) ){
            return $this->redirectToRoute('admin_line_train_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('Back/line_train/show.html.twig', [
            'line_train' => $lineTrain,
        ]);
    }

    #[IsGranted('ROLE_COMPANY')]
    #[Route('/{id}/edit', name: 'line_train_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, LineTrain $lineTrain, LineTrainRepository $lineTrainRepository, BookingRepository $bookingRepository, TrainRepository $trainRepository, LineRepository $lineRepository): Response
    {

        $travel = $lineTrainRepository->find($id);
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if ( $userConnected->getId() != $travel->getTrain()->getOwner()->getId() ){
            return $this->redirectToRoute('admin_line_train_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $errors = [];
        $success = [];
       
        $train = $trainRepository->findBy(["status" => 1,"owner"=> $userConnected->getId()]);
        $line = $lineRepository->findBy(["status" => 1]);
        $form = $this->createForm(LineTrainType::class, $lineTrain, ["train" => $train, "line" => $line]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $booking = $bookingRepository->findBy(['lineTrain' => $lineTrain->getId()]);
            if (!empty($booking)) {
                $errors[] = "Vous ne pouvez plus modifier ce voyage !";
            }

            $lonDeparture = $lineTrain->getLine()->getLongitudeDeparture();
            $latDeparture = $lineTrain->getLine()->getLatitudeDeparture();
            $lonArrival = $lineTrain->getLine()->getLongitudeArrival();
            $latArrival = $lineTrain->getLine()->getLatitudeArrival();

            $date = new DateTime($lineTrain->getDateDeparture()->format('Y-m-d') . " " . $lineTrain->getTimeDeparture()->format('H:i:s'));
            $date = $date->format('Y-m-d H:i:s');

            if ($date < date('Y-m-d H:i:s')) {
                $errors[] = "La date de départ ne peut pas être inférieur à celle d'aujourd'hui !";
            }

            $distance = Helper::distance($latDeparture, $lonDeparture, $latArrival, $lonArrival, "K");

            $getTime = ($distance * 60) / 300;
            $getTime = round($getTime * 3600 / 60);

            $dateTimeArrival = date("Y-m-d H:i:s", strtotime("$date +$getTime seconds"));

            $lineTrain->setDateArrival(new DateTime($dateTimeArrival));
            $lineTrain->setTimeArrival(new DateTime($dateTimeArrival));

            $getTrainByDate = $lineTrainRepository->findTrainByDate($lineTrain->getTrain()->getId(), $lineTrain->getId());
            $isBetween = false;

            if ($getTrainByDate) {

                foreach ($getTrainByDate as $value) {

                    if (($date >= $value["timestampdeparture"] && $date <= $value["timestamparrival"]) || ($dateTimeArrival >= $value["timestampdeparture"] && $date <= $value["timestamparrival"])) {
                        $isBetween = true;
                    }
                }
            }

            if ($isBetween) $errors[] = "Le train est indisponible à cette date !";

            if ($lineTrain->getDateDeparture() > $lineTrain->getDateArrival()) {
                $errors[] = "La date de départ ne peut pas être supérieur à la date d'arrivée";
            }

            if ($lineTrain->getDateDeparture() == $lineTrain->getDateArrival()) {

                if ($lineTrain->getTimeDeparture()->format('H-i-s') < date('H-i-s')) {
                    $errors[] = "Erreur horaire de départ !";
                }
                if ($lineTrain->getTimeDeparture() >= $lineTrain->getTimeArrival()) {
                    $errors[] = "L'horaire de départ ne peut pas être supérieur à l'horaire d'arrivée";
                }
            }

            if (empty($errors)) {

                $this->getDoctrine()->getManager()->flush();
                $success[] = "Le voyage a bien été modifié !";
              
                //return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
            } else {

                return $this->renderForm('Back/line_train/edit.html.twig', [
                    'line_train' => $lineTrain,
                    'form' => $form,
                    'errors' => $errors,
                    'success' => $success
                ]);
            }
        }

        return $this->renderForm('Back/line_train/edit.html.twig', [
            'line_train' => $lineTrain,
            'form' => $form,
            'errors' => $errors,
            'success' => $success
        ]);
    }

    #[Route('/plan/{id}', name: 'line_train_plan', methods: ['GET'])]
    public function plan(Request $request, int $id, BookingSeatRepository $bookingSeatRepository, LineTrainRepository $lineTrainRepository): Response
    {

        $travel = $lineTrainRepository->find($id);
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if ( $userConnected->getId() != $travel->getTrain()->getOwner()->getId()  && in_array('ROLE_COMPANY', $userConnected->getRoles()) ){
            return $this->redirectToRoute('admin_line_train_index', [], Response::HTTP_SEE_OTHER);
        }
       

        $seatNotAvailable = count($bookingSeatRepository->findSeatTravel($id));

    
        $getTrain = $travel->getTrain();
        $getWagons = $getTrain->getWagons()->getValues();
        $seatAvailable = 0;
        $wagons = [];
        foreach ($getWagons as $wagon) {

            if ($wagon->getStatus() == 1 ){
                $wagons[] = $wagon;
            }
            if ($wagon->getType() == "Voyageur" && $wagon->getStatus() == 1){
                $seatAvailable += $wagon->getPlaceNb();
            } 
        }

        return $this->render('Back/line_train/plan.html.twig', [
            "getWagons" => $wagons,
            "id" => $id,
            "train" => $getTrain,
            "seatNotAvailable" => $seatNotAvailable,
            "seatAvailable" => $seatAvailable - $seatNotAvailable
        ]);
    }

    #[Route('/display/seat/{id}', name: 'line_train_display_seat', methods: ['GET'])]
    public function displaySeat(Request $request, int $id, BookingSeatRepository $bookingSeatRepository): Response
    {

        if ($request->isXmlHttpRequest()) {

            $seat = $bookingSeatRepository->find($id);
            $output[] = [
                "lastname" => $seat->getLastname(),
                "firstname" => $seat->getFirstname(),
                "number" => $seat->getSeat()->getNumber(),
                "class" => $seat->getSeat()->getWagon()->getClass(),

            ];


            return new JsonResponse($output);
        }
        return new JsonResponse(false);
    }

    #[Route('/planning/{date}', name: 'line_train_planning_show', methods: ['GET'])]
    public function planningShow(LineTrainRepository $lineTrainRepository, Request $request, DateTime $date): Response
    {

        if ($request->isXmlHttpRequest()) {

            $output = [];

            $travels = $lineTrainRepository->findBy(
                ['date_departure' => $date],
                ['time_departure' => 'ASC'],

            );


            foreach ($travels as $travel) {


                $output[] = [
                    $travel->getId(),
                    $travel->getTrain()->getName(),
                    $travel->getLine()->getNameStationDeparture(),
                    $travel->getLine()->getNameStationArrival(),
                    $travel->getDateDeparture(),
                    $travel->getDateArrival(),
                    $travel->getTimeDeparture()->format('H:i'),
                    $travel->getTimeArrival()->format('H:i'),


                ];
            }

            return new JsonResponse($output);
        }
        return new JsonResponse(false);
    }
}
