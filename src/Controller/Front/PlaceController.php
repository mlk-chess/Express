<?php

namespace App\Controller\Front;

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

        return $this->render('Front/place/index.html.twig', [
            'places' => $placeRepository->findAll()
        ]);
    }
    /**
     * @Route("/place/{id}", name="place_show", requirements={"id"="\d+"})
     */
    public function show(Place $place) : Response {
        $em = $this->getDoctrine()->getManager();

        return $this->render('Front/place/show.html.twig', [
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
            return $this->redirectToRoute('place_index');
        }
        return $this->render('Front/place/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
