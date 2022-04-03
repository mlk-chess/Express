<?php

namespace App\Controller\Back;

use App\Entity\LineTrain;
use App\Form\LineTrainType;
use App\Repository\BookingRepository;
use App\Repository\LineRepository;
use App\Repository\LineTrainRepository;
use App\Service\Helper;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/line-train')]
class LineTrainController extends AbstractController
{
    #[Route('/', name: 'line_train_index', methods: ['GET'])]
    public function index(LineTrainRepository $lineTrainRepository): Response
    {

        return $this->render('Back/line_train/index.html.twig', [
            'line_trains' => $lineTrainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'line_train_new', methods: ['GET','POST'])]
    public function new(Request $request, LineTrainRepository $lineTrainRepository ): Response
    {

        $errors = [];
        $lineTrain = new LineTrain();
        $form = $this->createForm(LineTrainType::class, $lineTrain);
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
            
            if(empty($getWagonByTrain)){
                $errors[] = "Ce train n'a pas de wagon !";
            }else{
                foreach ($getWagonByTrain as $wagon){

                    if($wagon['type'] == "Voyageur"){
                        if($wagon['class'] == 1){
                            $placeNbclass1 += $wagon['placeNb'];
                        }else{
                            $placeNbclass2 += $wagon['placeNb'];
                        }
                    }
                }
    
                $lineTrain->setPlaceNbClass1($placeNbclass1);
                $lineTrain->setPlaceNbClass2($placeNbclass2);
            }
    
        

            $date = new DateTime($lineTrain->getDateDeparture()->format('Y-m-d') . " " . $lineTrain->getTimeDeparture()->format('H:i:s'));
            $date = $date->format('Y-m-d H:i:s');

            if($date < date('Y-m-d H:i:s')){
                $errors[] = "La date de départ ne peut pas être inférieur à celle d'aujourd'hui !";
            }
           
            $distance = Helper::distance($latDeparture,$lonDeparture,$latArrival,$lonArrival,"K");
           
            $getTime = ($distance * 60 ) / 300;
            $getTime = round($getTime * 3600 / 60);
        
            $dateTimeArrival = date( "Y-m-d H:i:s", strtotime( "$date +$getTime seconds"));

            $lineTrain->setDateArrival(new DateTime($dateTimeArrival));
            $lineTrain->setTimeArrival(new DateTime($dateTimeArrival));


            $getTrainByDate = $lineTrainRepository->findTrainByDate($lineTrain->getTrain()->getId());

            if($getTrainByDate){

                foreach( $getTrainByDate as $value){

                    if( ($date >= $value["timestampdeparture"] && $date <= $value["timestamparrival"]) || ($dateTimeArrival >= $value["timestampdeparture"] && $date <= $value["timestamparrival"]) ){
                        $isBetween = true;
                    }
                }
            }
           
            if ($isBetween) $errors[] = "Le train est indisponible à cette date !";

            if($lineTrain->getDateDeparture() > $lineTrain->getDateArrival()){
                $errors[] = "La date de départ ne peut pas être supérieur à la date d'arrivée";
            }

            if($lineTrain->getDateDeparture() == $lineTrain->getDateArrival()){

                if ($lineTrain->getTimeDeparture()->format('H-i-s') < date('H-i-s')){
                    $errors[] = "Erreur horaire de départ !";
                }
                if($lineTrain->getTimeDeparture() >= $lineTrain->getTimeArrival() ){
                    $errors[] = "L'horaire de départ ne peut pas être supérieur à l'horaire d'arrivée";
                }    
            }
            
            if(empty($errors)){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($lineTrain);
                $entityManager->flush();
                $this->addFlash('green', "Voyage crée !");
                return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
              
            }else{
                $this->addFlash('red', $errors[0]);
                return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('Back/line_train/new.html.twig', [
            'line_train' => $lineTrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'line_train_show', methods: ['GET'])]
    public function show(LineTrain $lineTrain): Response
    {
        return $this->render('Back/line_train/show.html.twig', [
            'line_train' => $lineTrain,
        ]);
    }

    #[Route('/{id}/edit', name: 'line_train_edit', methods: ['GET','POST'])]
    public function edit(Request $request, LineTrain $lineTrain, LineTrainRepository $lineTrainRepository, BookingRepository $bookingRepository): Response
    {
        $form = $this->createForm(LineTrainType::class, $lineTrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $booking = $bookingRepository->findBy(['lineTrain' => $lineTrain->getId()]);
            if(!empty($booking)){
                $errors[] = "Vous ne pouvez plus modifier ce voyage !";
            }

            $lonDeparture = $lineTrain->getLine()->getLongitudeDeparture();
            $latDeparture = $lineTrain->getLine()->getLatitudeDeparture();
            $lonArrival = $lineTrain->getLine()->getLongitudeArrival();
            $latArrival = $lineTrain->getLine()->getLatitudeArrival();

            $date = new DateTime($lineTrain->getDateDeparture()->format('Y-m-d') . " " . $lineTrain->getTimeDeparture()->format('H:i:s'));
            $date = $date->format('Y-m-d H:i:s');

            if($date < date('Y-m-d H:i:s')){
                $errors[] = "La date de départ ne peut pas être inférieur à celle d'aujourd'hui !";
            }

            $distance = Helper::distance($latDeparture,$lonDeparture,$latArrival,$lonArrival,"K");
           
            $getTime = ($distance * 60 ) / 300;
            $getTime = round($getTime * 3600 / 60);
        
            $dateTimeArrival = date( "Y-m-d H:i:s", strtotime( "$date +$getTime seconds"));

            $lineTrain->setDateArrival(new DateTime($dateTimeArrival));
            $lineTrain->setTimeArrival(new DateTime($dateTimeArrival));

            $getTrainByDate = $lineTrainRepository->findTrainByDate($lineTrain->getTrain()->getId(),$lineTrain->getId());
            $isBetween = false;

            if($getTrainByDate){

                foreach( $getTrainByDate as $value){

                    if( ($date >= $value["timestampdeparture"] && $date <= $value["timestamparrival"]) || ($dateTimeArrival >= $value["timestampdeparture"] && $date <= $value["timestamparrival"]) ){
                        $isBetween = true;
                    }
                }
            }

            if ($isBetween) $errors[] = "Le train est indisponible à cette date !";

            if($lineTrain->getDateDeparture() > $lineTrain->getDateArrival()){
                $errors[] = "La date de départ ne peut pas être supérieur à la date d'arrivée";
            }

            if($lineTrain->getDateDeparture() == $lineTrain->getDateArrival()){

                if ($lineTrain->getTimeDeparture()->format('H-i-s') < date('H-i-s')){
                    $errors[] = "Erreur horaire de départ !";
                }
                if($lineTrain->getTimeDeparture() >= $lineTrain->getTimeArrival() ){
                    $errors[] = "L'horaire de départ ne peut pas être supérieur à l'horaire d'arrivée";
                }    
            }

            if(empty($errors)){

                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('green', "Voyage modifié !");
                return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
              
            }else{
                $this->addFlash('red', $errors[0]);
                return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('Back/line_train/edit.html.twig', [
            'line_train' => $lineTrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'line_train_delete', methods: ['POST'])]
    public function delete(Request $request, LineTrain $lineTrain,BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineTrain->getId(), $request->request->get('_token'))) {
            
            $booking = $bookingRepository->findBy(['lineTrain' => $lineTrain->getId()]);

            if(empty($booking)){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($lineTrain);
                $entityManager->flush();
                $this->addFlash('green', "Voyage supprimé !");
            }else{
                $this->addFlash('red', "Impossible de supprimer ce voyage !");
            }
          
        }

        return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
    }
}
