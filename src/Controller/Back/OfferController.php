<?php

namespace App\Controller\Back;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offer')]
class OfferController extends AbstractController
{
    #[Route('/', name: 'offer_index', methods: ['GET'])]
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('Back/offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'offer_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('admin_offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'offer_show', methods: ['GET'])]
    public function show(Offer $offer): Response
    {
        return $this->render('Back/offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{id}/edit', name: 'offer_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Offer $offer): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'offer_delete', methods: ['POST'])]
    public function delete(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_offer_index', [], Response::HTTP_SEE_OTHER);
    }
}
