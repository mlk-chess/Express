<?php

namespace App\Controller\Back;

use App\Entity\LineTrain;
use App\Form\LineTrainType;
use App\Repository\LineTrainRepository;
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
    public function new(Request $request): Response
    {
        $lineTrain = new LineTrain();
        $form = $this->createForm(LineTrainType::class, $lineTrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lineTrain);
            $entityManager->flush();

            return $this->redirectToRoute('line_train_index', [], Response::HTTP_SEE_OTHER);
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
