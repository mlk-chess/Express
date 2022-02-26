<?php

namespace App\Controller\Front;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/option')]
class OptionController extends AbstractController
{
    #[Route('/', name: 'option_index', methods: ['GET'])]
    public function index(OptionRepository $optionRepository): Response
    {
        return $this->render('Front/option/index.html.twig', [
            'options' => $optionRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'option_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();

            return $this->redirectToRoute('option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/option/new.html.twig', [
            'option' => $option,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'option_show', methods: ['GET'])]
    public function show(Option $option): Response
    {
        return $this->render('Front/option/show.html.twig', [
            'option' => $option,
        ]);
    }

    #[Route('/{id}/edit', name: 'option_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Option $option): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/option/edit.html.twig', [
            'option' => $option,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'option_delete', methods: ['POST'])]
    public function delete(Request $request, Option $option): Response
    {
        if ($this->isCsrfTokenValid('delete'.$option->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($option);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Front/option_index', [], Response::HTTP_SEE_OTHER);
    }
}
