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
    //  #[Route('/', name: 'wagon_index', methods: ['GET'])]
    //  public function index(WagonRepository $wagonRepository): Response
    //  {
    //      $userConnected = $this->get('security.token_storage')->getToken()->getUser();

    //      if (in_array('COMPANY', $userConnected->getRoles())){
    //         return $this->render('Back/wagon/index.html.twig', [
    //             'wagons' => $wagonRepository->findBy(array('owner' => $userConnected->getId()))
    //         ]);
    //     }else{
    //          return $this->render('Back/wagon/index.html.twig', [
    //             'wagons' => $wagonRepository->findAll(),
    //         ]);
    //     }
    //  }

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
    public function edit(Request $request, Wagon $wagon, ): Response
    {
        
        $form = $this->createForm(WagonType::class, $wagon);
        $form->handleRequest($request);
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

       

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_wagon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/wagon/edit.html.twig', [
            'wagon' => $wagon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'wagon_delete', methods: ['POST'])]
    public function delete(Request $request, Wagon $wagon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wagon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wagon);
            $entityManager->flush();
            $this->addFlash('green', "Le Wagon à bien été supprimer.");
        }

        return $this->redirectToRoute('admin_wagon_index', [], Response::HTTP_SEE_OTHER);
    }
}
