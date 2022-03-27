<?php

namespace App\Controller\Back;

use App\Entity\LineTrain;
use App\Form\LineTrainType;
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

        // Vérification :
        //     - Cohérence des horaires : voir avec l'API sinon calcul (à voir) [OK]
        //     - Un train ne peut pas être sur 2 trajet à la fois [OK]
        //     - Voir le dernier trajet du train X et récupérer la gare d'arrivée [KO]
        //     - Calcul d'un certain laps de temps entre 2 trajet du même train [OK]
        //     - Prévoir un laps de temps pour le même trajet pour 2 trains différents 


        // 4 colonnes : Place restante -> place nb classe 1 -> si option classe 1 nb place ++
        //                                place nb classe 2 -> si option classe 2 nb place ++
        //                                prix classe 1 
        //                                prix classe 2

        // Vérification type voyageur 


        $errors = [];
        $lineTrain = new LineTrain();
        $form = $this->createForm(LineTrainType::class, $lineTrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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


            $getTrainByDate = $lineTrainRepository->findTrainByDate($lineTrain->getTrain()->getId());
            $isBetween = false;


            if($getTrainByDate){
                $getLastTrainByTime = $getTrainByDate[0]["timestamparrival"];

                foreach( $getTrainByDate as $value){

                    if( ($date >= $value["timestampdeparture"] && $date <= $value["timestamparrival"]) || ($dateTimeArrival >= $value["timestampdeparture"] && $date <= $value["timestamparrival"]) ){
                        $isBetween = true;
                    }
                
                    if( $value["timestamparrival"] < $date && $value["timestamparrival"] > $getLastTrainByTime  ){
                        $getLastTrainByTime = $value['timestamparrival'];
                    }
                }
                $checkTime = date( "Y-m-d H:i:s", strtotime( "$getLastTrainByTime +1 hour"));
                
                if($checkTime > $date){
                    $errors[] = "Le train est indisponible !";
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
    public function edit(Request $request, LineTrain $lineTrain): Response
    {
        $form = $this->createForm(LineTrainType::class, $lineTrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/line_train/edit.html.twig', [
            'line_train' => $lineTrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'line_train_delete', methods: ['POST'])]
    public function delete(Request $request, LineTrain $lineTrain): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineTrain->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lineTrain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
    }
}
