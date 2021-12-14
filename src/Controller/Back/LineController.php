<?php

namespace App\Controller\Back;

use App\Entity\Line;
use App\Form\LineType;
use App\Repository\LineRepository;
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
    public function new(Request $request): Response
    {
        $line = new Line();
        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($line);
            $entityManager->flush();

            return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/line/new.html.twig', [
            'line' => $line,
            'form' => $form,
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
    public function edit(Request $request, Line $line): Response
    {
        $form = $this->createForm(LineType::class, $line);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/line/edit.html.twig', [
            'line' => $line,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'line_delete', methods: ['POST'])]
    public function delete(Request $request, Line $line): Response
    {
        if ($this->isCsrfTokenValid('delete'.$line->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($line);
            $entityManager->flush();
        }

        return $this->redirectToRoute('line_index', [], Response::HTTP_SEE_OTHER);
    }
}
