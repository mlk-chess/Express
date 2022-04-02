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

                            $this->addFlash('green', "La ligne a été créée !");
                            return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
                        
                    }else{
                        $message = "Cette ligne existe déjà !";
                        $this->addFlash('red', $message);
                    }

                }else{
                    $message = "Gare de départ et gare d'arrivée identique !";
                    $this->addFlash('red', $message);
                }
            }
        }

        return $this->renderForm('Back/line/new.html.twig', [
            'line' => $line,
            'form' => $form
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
    public function edit(int $id, Request $request, Line $line,LineRepository $lineRepository): Response
    {
        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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

                                    $this->addFlash('green', "La ligne a été modifiée !");
                                    return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
                        
                            }else{
                                $message = "Cette ligne existe déjà !";
                                $this->addFlash('red', $message);
                            }
                    }else{
                        $message = "Gare de départ et gare d'arrivée identique !";
                        $this->addFlash('red', $message);
                    }
            }

        }

        return $this->renderForm('Back/line/edit.html.twig', [
            'line' => $line,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'line_delete', methods: ['POST'])]
    public function delete(Request $request, Line $line, LineTrainRepository $lineTrainRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$line->getId(), $request->request->get('_token'))) {
            
            if(empty($lineTrainRepository->findLineByLineTrain($line->getNameStationDeparture(), $line->getNameStationArrival()))){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($line);
                $entityManager->flush();
                $this->addFlash('green', "La ligne a été supprimée");
            }else{
                $this->addFlash('red', "La ligne ne peut pas être supprimée");
            }
           
        }

        return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
    }
}
