<?php

namespace App\Controller\Front;

use App\Entity\Wagon;
use App\Form\WagonType;
use App\Repository\WagonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wagon')]
class WagonController extends AbstractController
{
    #[Route('/', name: 'wagon_index', methods: ['GET'])]
    public function index(WagonRepository $wagonRepository): Response
    {
        return $this->render('Front/wagon/index.html.twig', [
            'wagons' => $wagonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'wagon_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $wagon = new Wagon();
        $form = $this->createForm(WagonType::class, $wagon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wagon);
            $entityManager->flush();

            return $this->redirectToRoute('wagon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/wagon/new.html.twig', [
            'wagon' => $wagon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'wagon_show', methods: ['GET'])]
    public function show(Wagon $wagon): Response
    {
        return $this->render('Front/wagon/show.html.twig', [
            'wagon' => $wagon,
        ]);
    }

    #[Route('/{id}/edit', name: 'wagon_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Wagon $wagon): Response
    {
        $form = $this->createForm(WagonType::class, $wagon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wagon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/wagon/edit.html.twig', [
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
        }

        return $this->redirectToRoute('wagon_index', [], Response::HTTP_SEE_OTHER);
    }
}
