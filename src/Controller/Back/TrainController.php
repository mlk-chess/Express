<?php

namespace App\Controller\Back;

use App\Entity\Train;
use App\Form\TrainType;
use App\Repository\LineTrainRepository;
use App\Repository\WagonRepository;
use App\Repository\TrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/train')]
class TrainController extends AbstractController
{
    #[Route('/', name: 'train_index', methods: ['GET'])]
    public function index(TrainRepository $trainRepository): Response
    {
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();
        if (in_array('ROLE_COMPANY', $userConnected->getRoles())){
            return $this->render('Back/train/index.html.twig', [
                'trains' => $trainRepository->findBy(['owner' => $userConnected->getId(), 'status' => 1])
                ]);
        }else{
            return $this->render('Back/train/index.html.twig', [
                'trains' => $trainRepository->findBy(['status' => 1])
            ]);
        }
    }

    #[IsGranted('ROLE_COMPANY')]
    #[Route('/new', name: 'train_new', methods: ['GET','POST'])]
    public function new(Request $request, TrainRepository $trainRepository): Response
    {
        $train = new Train();
        $form = $this->createForm(TrainType::class, $train);
        $form->handleRequest($request);
        $errors = [];
        $success = [];

        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $train->setOwner($userConnected);
            
            if (empty($trainRepository->findBy(["name" => $train->getName(), "status" => 1]))){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($train);
                $entityManager->flush();
                $success[] = "Train créé !";
                //return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
            }else{
                $errors[] = "Ce train existe déjà !";
            }
          

        }
        return $this->renderForm('Back/train/new.html.twig', [
            'train' => $train,
            'form' => $form,
            'errors' => $errors,
            'success' => $success
        ]);
    }

    #[Route('/{id}', name: 'train_show', methods: ['GET'])]
    public function show(Train $train, WagonRepository $wagonRepository, int $id, TrainRepository $trainRepository): Response
    {

        $travel = $trainRepository->find($id);
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if ($travel->getOwner()->getId() != $userConnected->getId() && in_array('ROLE_COMPANY', $userConnected->getRoles()) ){
            return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
        }
        

        $wagons = $wagonRepository->findBy(["status" => 1, "train" => $id]);
        return $this->render('Back/train/show.html.twig', [
            'train' => $train,
            'wagons' => $wagons
        ]);
    }

    #[IsGranted('ROLE_COMPANY')]
    #[Route('/{id}/edit', name: 'train_edit', methods: ['GET','POST'])]
    public function edit(Request $request, int $id, Train $train, TrainRepository $trainRepository, LineTrainRepository $lineTrainRepository): Response
    {
        $form = $this->createForm(TrainType::class, $train);
        $form->handleRequest($request);
        $errors = [];
        $success = [];

        $travel = $trainRepository->find($id);

        $userConnected = $this->get('security.token_storage')->getToken()->getUser();
        if ($travel->getOwner()->getId() != $userConnected->getId()){
            return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $travels = $lineTrainRepository->findBy(['train' => $train->getId()]);
            foreach($travels as $travel){
                if($travel->getDateArrival()->format('Y-m-d') > date('Y-m-d')){
                    $errors[] = "Le train associé a un voyage de prévu, vous ne pouvez pas modifier ce train.";
                    break;
                }   
            }

            if (empty($errors)){
                $this->getDoctrine()->getManager()->flush();
                $success[] = "Le train a bien été modifié !";
                //return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('Back/train/edit.html.twig', [
            'train' => $train,
            'form' => $form,
            'errors' => $errors,
            'success' => $success
        ]);
    }

    #[IsGranted('ROLE_COMPANY')]
    #[Route('/{id}/disable', name: 'train_disable')]
    public function disable(Request $request, Train $train, LineTrainRepository $lineTrainRepository): Response
    {
       
            $errors = [];
           
            $userConnected = $this->get('security.token_storage')->getToken()->getUser();

            if ($train->getOwner()->getId() == $userConnected->getId()){

                $travels = $lineTrainRepository->findBy(['train' => $train->getId()]);
                foreach($travels as $travel){
                    if($travel->getDateArrival()->format('Y-m-d') > date('Y-m-d')){
                        $errors[] = "Le train associé a un voyage de prévu, vous ne pouvez pas désactiver ce train.";
                        break;
                    }   
                }
    
                if(empty($errors)){
    
                    $entityManager = $this->getDoctrine()->getManager();
                    $train->setStatus(0);
                    $entityManager->persist($train);
                    $entityManager->flush();
        
                }
            }

            return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
    }
}
