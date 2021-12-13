<?php

namespace App\Controller\Back;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Component\HttpFoundation\Request;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    /**
     * @Route("/place", name="place_index")
     */
    public function index(PlaceRepository $placeRepository): Response
    {
        // Entity = définition de la BDD uniquement
        // Repository = Permet de customiser des requetes

        return $this->render('Back/place/index.html.twig', [
            'places' => $placeRepository->findAll()
        ]);
    }
    /**
     * @Route("/place/{id}", name="place_show", requirements={"id"="\d+"})
     */
    public function show(Place $place) : Response {
        $em = $this->getDoctrine()->getManager();

        return $this->render('Back/place/show.html.twig', [
            'place' =>$place
        ]);
    }

    /**
     * @Route("/place/create", name="place_create")
     */
    public function create(Request $request) : Response {

        $place = new Place();
        //Valeur par défaut
        //$place->setCity('aaa');
        $form = $this->createForm(PlaceType::class, $place);

        // handleRequest -> Permet de remplir les données
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            //Persist == commit sur git (je save mais je publie pas)
            $em->persist($place);
            // flush == push sur git
            $em->flush();
            $this->addFlash('green', "le lieu {$place->getName()} à bien été créer.");
            return $this->redirectToRoute('admin_place_index');
        }
        return $this->render('Back/place/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/place/edit/{id}", name="place_edit")
     */
    public function edit(Place $place, Request $request){

        $em = $this->getDoctrine()->getManager();

        //$place = new Place();
        //$place->setCity('aaa');
        $form = $this->createForm(PlaceType::class, $place);

        // handleRequest -> Permet de remplir les données
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager()->flush();
            // flush == push sur git

            //Message flash
            $this->addFlash('green', "le lieu {$place->getName()} à bien été édité.");
            return $this->redirectToRoute('admin_place_show', ['id' => $place->getId()]);
        }
        return $this->render('Back/place/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/place/remove/{id}/{token}", name="place_remove")
     */
    public function remove(Place $place, $token) : Response{

        if ($this->isCsrfTokenValid('place_remove', $token)){
            $em = $this->getDoctrine()->getManager();
            $em->remove($place);
            $em->flush();

            $this->addFlash('red', "le lieu {$place->getName()} à bien été supprimé.");

            return $this->redirectToRoute('admin_place_index');
        }

        throw new Exception('Invalid token CSRF');
    }
}
