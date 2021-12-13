<?php

namespace App\Controller\Back;

use App\Entity\Victim;
use App\Form\VictimType;
use App\Repository\VictimRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/victim')]
class VictimController extends AbstractController
{
    #[Route('/', name: 'victim_index', methods: ['GET'])]
    public function index(VictimRepository $victimRepository): Response
    {
        return $this->render('Back/victim/index.html.twig', [
            'victims' => $victimRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'victim_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $victim = new Victim();
        $form = $this->createForm(VictimType::class, $victim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($victim);
            $entityManager->flush();

            return $this->redirectToRoute('admin_victim_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/victim/new.html.twig', [
            'victim' => $victim,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'victim_show', methods: ['GET'])]
    public function show(Victim $victim): Response
    {
        return $this->render('Back/victim/show.html.twig', [
            'victim' => $victim,
        ]);
    }

    #[Route('/{id}/edit', name: 'victim_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Victim $victim): Response
    {
        $form = $this->createForm(VictimType::class, $victim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_victim_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/victim/edit.html.twig', [
            'victim' => $victim,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'victim_delete', methods: ['POST'])]
    public function delete(Request $request, Victim $victim): Response
    {
        if ($this->isCsrfTokenValid('delete'.$victim->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($victim);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_victim_index', [], Response::HTTP_SEE_OTHER);
    }
}
