<?php

namespace App\Controller\Back;

use App\Entity\LigneTrain;
use App\Form\LigneTrainType;
use App\Repository\LigneTrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ligne_train')]
class LigneTrainController extends AbstractController
{
    #[Route('/', name: 'ligne_train_index', methods: ['GET'])]
    public function index(LigneTrainRepository $ligneTrainRepository): Response
    {
        return $this->render('Back/ligne_train/index.html.twig', [
            'ligne_trains' => $ligneTrainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'ligne_train_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $ligneTrain = new LigneTrain();
        $form = $this->createForm(LigneTrainType::class, $ligneTrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ligneTrain);
            $entityManager->flush();

            return $this->redirectToRoute('ligne_train_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/ligne_train/new.html.twig', [
            'ligne_train' => $ligneTrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'ligne_train_show', methods: ['GET'])]
    public function show(LigneTrain $ligneTrain): Response
    {
        return $this->render('Back/ligne_train/show.html.twig', [
            'ligne_train' => $ligneTrain,
        ]);
    }

    #[Route('/{id}/edit', name: 'ligne_train_edit', methods: ['GET','POST'])]
    public function edit(Request $request, LigneTrain $ligneTrain): Response
    {
        $form = $this->createForm(LigneTrainType::class, $ligneTrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ligne_train_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/ligne_train/edit.html.twig', [
            'ligne_train' => $ligneTrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'ligne_train_delete', methods: ['POST'])]
    public function delete(Request $request, LigneTrain $ligneTrain): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneTrain->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ligneTrain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ligne_train_index', [], Response::HTTP_SEE_OTHER);
    }
}
