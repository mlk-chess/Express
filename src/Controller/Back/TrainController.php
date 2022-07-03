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
        if (in_array('COMPANY', $userConnected->getRoles())){
            return $this->render('Back/train/index.html.twig', [
                'trains' => $trainRepository->findBy(['owner' => $userConnected->getId(), 'status' => 1])
                ]);
        }else{
            return $this->render('Back/train/index.html.twig', [
                'trains' => $trainRepository->findBy(['status' => 1])
            ]);
        }
    }

    #[Route('/new', name: 'train_new', methods: ['GET','POST'])]
    public function new(Request $request, TrainRepository $trainRepository): Response
    {
        $train = new Train();
        $form = $this->createForm(TrainType::class, $train);
        $form->handleRequest($request);
        $errors = [];

        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $train->setOwner($userConnected);
            
            if (empty($trainRepository->findBy(["name" => $train->getName(), "status" => 1]))){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($train);
                $entityManager->flush();
    
                return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
            }else{
                $errors[] = "Ce train existe déjà !";
            }
          

        }
        return $this->renderForm('Back/train/new.html.twig', [
            'train' => $train,
            'form' => $form,
            'errors' => $errors
        ]);
    }

    #[Route('/{id}', name: 'train_show', methods: ['GET'])]
    public function show(Train $train, WagonRepository $wagonRepository): Response
    {

        $wagons = $wagonRepository->findBy(["status" => 1]);
        return $this->render('Back/train/show.html.twig', [
            'train' => $train,
            'wagons' => $wagons
        ]);
    }

    #[Route('/{id}/edit', name: 'train_edit', methods: ['GET','POST'])]
    public function edit(Request $request, int $id, Train $train, TrainRepository $trainRepository): Response
    {
        $form = $this->createForm(TrainType::class, $train);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
          
        }

        return $this->renderForm('Back/train/edit.html.twig', [
            'train' => $train,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/disable', name: 'train_disable')]
    public function disable(Request $request, Train $train, LineTrainRepository $lineTrainRepository): Response
    {
       
            $errors = [];
            $userConnected = $this->get('security.token_storage')->getToken()->getUser();

            if ($train->getOwner()->getId() == $userConnected->getId()){

                $travels = $lineTrainRepository->findBy(['train' => $train->getId()]);
                foreach($travels as $travel){
                    if($travel->getDateArrival()->format('Y-m-d') > date('Y-m-d')){
                        $errors[] = "Le train associé a un voyage de prévu, vous ne pouvez pas désactiver cette ligne.";
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
