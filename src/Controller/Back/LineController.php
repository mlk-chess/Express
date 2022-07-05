<?php

namespace App\Controller\Back;

use App\Entity\Line;
use App\Form\LineType;
use App\Repository\LineRepository;
use App\Repository\LineTrainRepository;
use App\Service\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/line')]
class LineController extends AbstractController
{
    #[Route('/', name: 'line_index', methods: ['GET'])]
    public function index(LineRepository $lineRepository): Response
    {
        return $this->render('Back/line/index.html.twig', [
            'lines' => $lineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'line_new', methods: ['GET','POST'])]
    public function new(Request $request, LineRepository $lineRepository): Response
    {
        $line = new Line();
        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);

        $success = [];
        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {

            if (Helper::checkStationJsonFile($line->getNameStationArrival()) &&
                Helper::checkStationJsonFile($line->getNameStationDeparture())){

                if($line->getNameStationArrival() !== $line->getNameStationDeparture() ){

                    $getLine = $lineRepository->findOneBy([
                        'name_station_departure' => $line->getNameStationDeparture(),
                        'name_station_arrival' => $line->getNameStationArrival()
                    ]);

                    $getLineDeparture = Helper::getLineByName('../public/stations.json',$line->getNameStationDeparture());
                    $getLineArrival = Helper::getLineByName('../public/stations.json',$line->getNameStationArrival());

                    if ($getLine == null){

                            $entityManager = $this->getDoctrine()->getManager();

                            $line->setLatitudeDeparture($getLineDeparture['Latitude']);
                            $line->setLatitudeArrival($getLineArrival['Latitude']);
                            $line->setLongitudeDeparture($getLineDeparture['Longitude']);
                            $line->setLongitudeArrival($getLineArrival['Longitude']);

                            $entityManager->persist($line);
                            $entityManager->flush();

                            $success[] = "La ligne a été créée !";

                            return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
                        
                    }else{
                        $errors[] = "Cette ligne existe déjà !";
                     
                    }

                }else{
                    $errors[] = "Gare de départ et gare d'arrivée identique !";
                
                }
            }
        }

        return $this->renderForm('Back/line/new.html.twig', [
            'line' => $line,
            'form' => $form,
            'errors' => $errors
        ]);
    }

    #[Route('/{id}', name: 'line_show', methods: ['GET'])]
    public function show(Line $line): Response
    {
        return $this->render('Back/line/show.html.twig', [
            'line' => $line,
        ]);
    }

    #[Route('/{id}/edit', name: 'line_edit', methods: ['GET','POST'])]
    public function edit(int $id, Request $request, Line $line,LineRepository $lineRepository,LineTrainRepository $lineTrainRepository): Response
    {
        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);
        $success = [];
        $errors = [];


        $travels = $lineTrainRepository->findBy(
            ['line' => $line->getId()]
        );


        if ($form->isSubmitted() && $form->isValid()) {

            foreach($travels as $travel){
                if($travel->getDateArrival()->format('Y-m-d') > date('Y-m-d')){
                    $errors[] = "Le train associé a un voyage de prévu, vous ne pouvez pas modifier cette ligne.";
                    break;
                }   
            }
            
            if (empty($errors)){
                if (Helper::checkStationJsonFile($line->getNameStationArrival()) &&
                    Helper::checkStationJsonFile($line->getNameStationDeparture())) {

                    if($line->getNameStationArrival() !== $line->getNameStationDeparture() ){
                    
                            $getLine = $lineRepository->findOneBy([
                                'name_station_departure' => $line->getNameStationDeparture(),
                                'name_station_arrival' => $line->getNameStationArrival()
                            ]);

                            $getLineDeparture = Helper::getLineByName('../public/stations.json',$line->getNameStationDeparture());
                            $getLineArrival = Helper::getLineByName('../public/stations.json',$line->getNameStationArrival());
            
                            if ( $getLine == null || $getLine->getId() == $id ){
            
                                    $line->setLatitudeDeparture($getLineDeparture['Latitude']);
                                    $line->setLatitudeArrival($getLineArrival['Latitude']);
                                    $line->setLongitudeDeparture($getLineDeparture['Longitude']);
                                    $line->setLongitudeArrival($getLineArrival['Longitude']);
            
                                    $this->getDoctrine()->getManager()->flush();

                                    $success[] = "La ligne a été modifiée !";
                                    return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
                        
                            }else{
                                $errors[] = "Cette ligne existe déjà !";
                              
                            }
                    }else{
                        $errors[] = "Gare de départ et gare d'arrivée identique !";
                      
                    }
                }
            }

        }

        return $this->renderForm('Back/line/edit.html.twig', [
            'line' => $line,
            'form' => $form,
            'errors' => $errors,
            'success' => $success
        ]);
    }


    #[Route('/{id}/enable', name: 'line_enable')]
    public function enable(Request $request, Line $line, LineTrainRepository $lineTrainRepository): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $line->setStatus(1);
        $entityManager->persist($line);
        $entityManager->flush();

        return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/disable', name: 'line_disable')]
    public function disable(Request $request, Line $line, LineTrainRepository $lineTrainRepository): Response
    {
      
        $errors = [];
            
        $travels = $lineTrainRepository->findBy(['line' => $line->getId()]);
        foreach($travels as $travel){
            if($travel->getDateArrival()->format('Y-m-d') > date('Y-m-d')){
                $errors[] = "Le train associé a un voyage de prévu, vous ne pouvez pas désactiver cette ligne.";
                break;
            }   
        }

        if(empty($errors)){

            $entityManager = $this->getDoctrine()->getManager();
            $line->setStatus(0);
            $entityManager->persist($line);
            $entityManager->flush();

        }

        return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
    }


   
}
