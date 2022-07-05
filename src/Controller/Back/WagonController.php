<?php

namespace App\Controller\Back;

use App\Entity\Wagon;
use App\Form\WagonType;
use App\Entity\Train;
use App\Entity\Seat;
use App\Repository\SeatRepository;
use App\Repository\TrainRepository;
use App\Repository\WagonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wagon')]
class WagonController extends AbstractController
{

    #[Route('/new/{id}', name: 'wagon_new', methods: ['GET','POST'])]
    public function new(Request $request, int $id,  Train $train, TrainRepository $trainRepository, SeatRepository $seatRepository): Response
    {

       
        $wagon = new Wagon();
        $form = $this->createForm(WagonType::class, $wagon);
        $form->handleRequest($request);
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();
        $error = [];

        if($trainRepository->findBy(["id" => $train->getId(),"owner" => $userConnected->getId()])){

           if ($form->isSubmitted() && $form->isValid()) {
                
                if($wagon->getPlaceNb() > 24){
                    $error[] = "Nombre de place est limité à 24 !";
                }

                if($wagon->getType() == 'Bar' && $wagon->getPlaceNb() > 0){
                    $error[] = "Un bar ne peut pas contenir de place !";
                }

                $wagon->setOwner($userConnected);
                $wagon->setTrain($train);
                $travels = $wagon->getTrain()->getLineTrains();
                foreach($travels as $travel){
                    if($travel->getDateArrival()->format('Y-m-d') > date('Y-m-d')){
                        $error[] = "Le train associé a un voyage de prévu, vous ne pouvez pas ajouter de wagon.";
                        break;
                    }   
                } 

                if( !empty($error) ){
                  
                    return $this->renderForm('Back/wagon/new.html.twig', [
                        'wagon' => $wagon,
                        'form' => $form,
                        'errors' => $error
                    ]);

                }else{

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($wagon);
                    $entityManager->flush();

                    for($i = 1; $i <= $wagon->getPlaceNb();$i++){
                        $seat = new Seat();
                        $seat->setNumber($i);
                        $seat->setWagon($wagon);
                        $seat->setName('Wagon');

                        $entityManager->persist($seat);
                       
                    }
                    $entityManager->flush();

                    return $this->redirectToRoute('admin_train_show', ['id' => $train->getId()], Response::HTTP_SEE_OTHER);
                }
            }

            return $this->renderForm('Back/wagon/new.html.twig', [
                'wagon' => $wagon,
                'form' => $form,
                'errors' => $error
            ]);
        }else{
            return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
        }
    
    }

    #[Route('/{id}', name: 'wagon_show', methods: ['GET'])]
    public function show(Wagon $wagon): Response
    {
        return $this->render('Back/wagon/show.html.twig', [
            'wagon' => $wagon,
        ]);
    }


    #[Route('/{id}/edit', name: 'wagon_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Wagon $wagon, WagonRepository $wagonRepository, SeatRepository $seatRepository): Response
    {
        
        $form = $this->createForm(WagonType::class, $wagon);
        $form->handleRequest($request);
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();
        $errors = [];

        if ($wagon->getTrain()->getOwner()->getId() == $userConnected->getId()){

            if ($form->isSubmitted() && $form->isValid()) {
                
                if($wagon->getPlaceNb() > 24){
                    $error[] = "Nombre de place est limité à 24 !";
                }

                if($wagon->getType() == 'Bar' && $wagon->getPlaceNb() > 0){
                    $error[] = "Un bar ne peut pas contenir de place !";
                }

                $travels = $wagon->getTrain()->getLineTrains();
                foreach($travels as $travel){
                    if($travel->getDateArrival()->format('Y-m-d') > date('Y-m-d')){
                        $errors[] = "Le train associé a un voyage de prévu, vous ne pouvez pas modifier ce wagon.";
                        break;
                    }   
                }
                
                if (!empty($errors)){
                
                    return $this->renderForm('Back/wagon/edit.html.twig', [
                        'wagon' => $wagon,
                        'form' => $form,
                    ]);

                }else{


                    $this->getDoctrine()->getManager()->flush();
                    $seats = $seatRepository->findBy(
                        ['wagon' => $wagon->getId()]
                    );

                    $entityManager = $this->getDoctrine()->getManager();

                    foreach($seats as $seat){
                        $entityManager->remove($seat);
                    }
            
                    $entityManager->flush();

                    for($i = 1; $i <= $wagon->getPlaceNb();$i++){
                        $seat = new Seat();
                        $seat->setNumber($i);
                        $seat->setWagon($wagon);
                        $seat->setName('Wagon');

                        $entityManager->persist($seat);
                       
                    }
                    $entityManager->flush();


                    //return $this->redirectToRoute('admin_wagon_show', ['id' => $wagon->getId()], Response::HTTP_SEE_OTHER);
                }      
            }
         
            return $this->renderForm('Back/wagon/edit.html.twig', [
                'wagon' => $wagon,
                'form' => $form,
            ]);
        }else{
            return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
        }
       
    }

    #[Route('/{id}/disable', name: 'wagon_disable',)]
    public function disable(Request $request, Wagon $wagon): Response
    {
        $errors = [];
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if ($wagon->getOwner()->getId() == $userConnected->getId()){

            $travels = $wagon->getTrain()->getLineTrains();
            foreach($travels as $travel){
                if($travel->getDateArrival()->format('Y-m-d') > date('Y-m-d')){
                    $errors[] = "Le train associé a un voyage de prévu, vous ne pouvez pas désactiver ce wagon.";
                    break;
                }   
            }

            if(empty($errors)){
    
                $entityManager = $this->getDoctrine()->getManager();
                $wagon->setStatus(0);
                $entityManager->persist($wagon);
                $entityManager->flush();
    
            }

        }


        return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
    }
}
