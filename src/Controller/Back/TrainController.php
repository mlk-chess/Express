<?php

namespace App\Controller\Back;

use App\Entity\Train;
use App\Form\TrainType;
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
                'trains' => $trainRepository->findBy(array('owner' => $userConnected->getId()))
                ]);
        }else{
            return $this->render('Back/train/index.html.twig', [
                'trains' => $trainRepository->findAll(),
            ]);
        }

    }

    #[Route('/new', name: 'train_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $train = new Train();
        $form = $this->createForm(TrainType::class, $train);
        $form->handleRequest($request);

        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $train->setOwner($userConnected);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($train);
            $entityManager->flush();

            $this->addFlash('green', "Le train {$train->getName()} à bien été créer.");

            return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/train/new.html.twig', [
            'train' => $train,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'train_show', methods: ['GET'])]
    public function show(Train $train): Response
    {
        return $this->render('Back/train/show.html.twig', [
            'train' => $train,
        ]);
    }

    #[Route('/{id}/edit', name: 'train_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Train $train): Response
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

    #[Route('/{id}', name: 'train_delete', methods: ['POST'])]
    public function delete(Request $request, Train $train): Response
    {
        if ($this->isCsrfTokenValid('delete'.$train->getId(), $request->request->get('_token'))) {

            //dd($train);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($train);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_train_index', [], Response::HTTP_SEE_OTHER);
    }
}
