<?php

namespace App\Controller\Back;

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
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();

        if (in_array('COMPANY', $userConnected->getRoles())){
            return $this->render('Back/wagon/index.html.twig', [
                'wagons' => $wagonRepository->findBy(array('owner' => $userConnected->getId()))
            ]);
        }else{
            return $this->render('Back/wagon/index.html.twig', [
                'wagons' => $wagonRepository->findAll(),
            ]);
        }
    }

    #[Route('/new', name: 'wagon_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $wagon = new Wagon();
        $form = $this->createForm(WagonType::class, $wagon);
        $form->handleRequest($request);
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();
        $error = null;
        if ($form->isSubmitted() && $form->isValid()) {
            for ($i = 0; $i < sizeof($wagon->getTrain()->getLineTrains()); $i++){
                if ($wagon->getTrain()->getLineTrains()->get($i)->getId() == $wagon->getTrain()->getId()){

                    $this->addFlash('red', "Le train associé a un voyage de prévu, vous ne pouvez pas ajouter de wagon.");
                    $error = "Le train associé a un voyage de prévu, vous ne pouvez pas ajouter de wagon.";

                    return $this->renderForm('Back/wagon/new.html.twig', [
                        'wagon' => $wagon,
                        'form' => $form,
                        'errors' => $error
                    ]);
                }
            }

            $wagon->setOwner($userConnected);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wagon);
            $entityManager->flush();

            $this->addFlash('green', "Le Wagon à bien été créer.");

            return $this->redirectToRoute('admin_wagon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/wagon/new.html.twig', [
            'wagon' => $wagon,
            'form' => $form,
            'errors' => $error
        ]);
    }

    #[Route('/{id}', name: 'wagon_show', methods: ['GET'])]
    public function show(Wagon $wagon): Response
    {
        return $this->render('Back/wagon/show.html.twig', [
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

            return $this->redirectToRoute('admin_wagon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/wagon/edit.html.twig', [
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
            $this->addFlash('green', "Le Wagon à bien été supprimer.");
        }

        return $this->redirectToRoute('admin_wagon_index', [], Response::HTTP_SEE_OTHER);
    }
}
