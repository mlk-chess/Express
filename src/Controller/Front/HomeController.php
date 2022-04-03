<?php

namespace App\Controller\Front;

use App\Entity\Booking;
use App\Entity\LineTrain;
use App\Entity\Option;
use App\Form\HomeType;
use App\Repository\BookingRepository;
use App\Repository\LineTrainRepository;
use DateTime;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use function Doctrine\Common\Cache\Psr6\set;

#[Route('/home')]
class HomeController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $session = $this->requestStack->getSession();
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(HomeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('departureStationInput')->getData() == null || $form->get('arrivalStationInput')->getData() == null) {
                $this->addFlash('red', "La gare de départ et la gare d'arrivée doivent être remplis");

                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            }

            $date = new DateTime($form->get('date')->getData()->format('d-m-Y'));
            $time = new DateTime($form->get('time')->getData()->format('H:i:s'));
            $date->setTime($time->format('H'), $time->format('i'), $time->format('s'));

            if ($date->format('d-m-Y H:i:s') <= date('d-m-Y H:i:s', time())) {
                $this->addFlash('red', "La date et l'heure ne sont pas valides");

                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(LineTrain::class);


            $query = $repository->createQueryBuilder('lt')
                ->select('lt, line')
                ->leftJoin('lt.line', 'line')
                ->where('line.name_station_departure = :station_departure')
                ->andWhere('line.name_station_arrival = :station_arrival')
                ->andWhere('lt.date_departure = :date_departure')
                ->andWhere('lt.time_departure >= :time_departure')
                ->setParameters([
                    'station_departure' => $form->get('departureStationInput')->getData(),
                    'station_arrival' => $form->get('arrivalStationInput')->getData(),
                    'date_departure' => $form->get('date')->getData()->format('Y-m-d'),
                    'time_departure' => $form->get('time')->getData()->format('H:i:s')
                ]);


            $q = $query->getQuery();

            $travels = $q->execute();

            if (count($travels) === 0) {
                $noTravels = true;
            } else {
                $noTravels = false;
            }

            return $this->renderForm('Front/home/index.html.twig', [
                'controller_name' => 'HomeController',
                'form' => $form,
                'travels' => $travels,
                'noTravels' => $noTravels
            ]);

        }

        return $this->renderForm('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form,
            'travels' => false,
            'noTravels' => false
        ]);
    }

    #[Route('/shopping', name: 'shopping')]
    public function shopping(Request $request): Response
    {
        $session = $this->requestStack->getSession();
        $dataSession = $session->get('shopping');

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(LineTrain::class);

        $travels = [];
        $total = 0;

        foreach ($dataSession as $key => $value) {
            $query = $repository->createQueryBuilder('lt')
                ->select('lt, line')
                ->leftJoin('lt.line', 'line')
                ->where('lt.id = :id')
                ->setParameters([
                    'id' => $value[0]
                ]);

            $q = $query->getQuery();

            $travel = $q->execute();
            array_push($travels, [$travel[0], $value[1], $key]);
            if ($value[1] === 1){
                $total += $travel[0]->getPriceClass1();
            }else{
                $total += $travel[0]->getPriceClass2();
            }
        }
        return $this->renderForm('Front/home/shopping.html.twig', [
            'controller_name' => 'HomeController',
            'travels' => $travels,
            'total' => $total
        ]);
    }

    #[Route('/stations', name: 'stations')]
    public function getStations(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $json = file_get_contents("../templates/Front/home/stations.json");
            return new JsonResponse($json);
        }
        return new JsonResponse(false);
    }

    #[Route('/add-option', name: 'addOption')]
    public function addOption(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $id = intval($request->request->get('id'));
            $classWagon = intval($request->request->get('classWagon'));

            $session = $this->requestStack->getSession();
            $dataSession = $session->get('shopping');

            if ($dataSession === null){
                $session->set('shopping', [[$id, $classWagon]]);
            } else {
                array_push($dataSession, [$id, $classWagon]);
                $session->set('shopping', $dataSession);
            }

            $session->get('shopping');

            return new JsonResponse(true);
        }
        return new JsonResponse(false);
    }
    #[Route('/success', name: 'success', methods: ['GET','POST'])]
    public function success(Request $request, LineTrainRepository $lineTrainRepository, BookingRepository $bookingRepository): Response
    {
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();
        $session = $this->requestStack->getSession();
        $dataSession = $session->get('shopping');
        for ($i = 0; $i < sizeof($dataSession)-1; $i++) {
            $idVoyage = $dataSession[$i][0];
            $class = $dataSession[$i][1];
            $voyage = $lineTrainRepository->findBy(array('id' => $idVoyage));
            $price = null;
            if ($class == '1') {
                $voyage[0]->setPlaceNbClass1($voyage[0]->getPlaceNbClass1()-1);
                $price = $voyage[0]->getPriceClass1();
            } else if ($class == '2') {
                $voyage[0]->setPlaceNbClass2($voyage[0]->getPlaceNbClass2()-1);
                $price = $voyage[0]->getPriceClass2();
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyage[0]);
            $entityManager->flush();

            $booking = new Booking();
            $booking->setLineTrain($voyage[0]);
            $booking->setPrice($price);
            $booking->setStatus(1);

            $booking->setIdUser($userConnected);
            $booking->setPaymentIntent($dataSession["payment_intent"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();
        }

        $session->remove('shopping');
        return $this->render('Front/home/success.html.twig');
    }

    #[Route('/payment', name: 'payment', methods: ['GET','POST'])]
    public function payment(Request $request, LineTrainRepository $lineTrainRepository): Response
    {

        // This is your test secret API key.
        \Stripe\Stripe::setApiKey('sk_test_51Kk6uiCJ5s87DbRlsu9UTG7t0PbKcXlXM7bxLdibROOksHgDXIg1gXtp0SFv7o0MZxTcCTOLmEzjK1AVvdCR9LXg00vHipH4ZP');

        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'http://localhost:8090/';
        $session = $this->requestStack->getSession();
        $dataSession = $session->get('shopping');
        $price = 0;
        $placeClass1 = 0;
        $placeClass2 = 0;

        for ($i = 0; $i < sizeof($dataSession); $i++){
            $idVoyage = $dataSession[$i][0];
            $class = $dataSession[$i][1];

            $voyage = $lineTrainRepository->findBy(array('id' => $idVoyage));

            if ($class == '1'){
                if ($voyage[0]->getPlaceNbClass1()-1 < 0){
                    return $this->render('Front/home/error.html.twig');
                }else{
                    $voyage[0]->setPlaceNbClass1($voyage[0]->getPlaceNbClass1()-1);
                }
                $placeClass1 += 1;
                $price += $voyage[0]->getPriceClass1();
            }else if($class == '2'){
                if ($voyage[0]->getPlaceNbClass2()-1 < 0){
                    return $this->render('Front/home/error.html.twig');
                }else{
                    $voyage[0]->setPlaceNbClass2($voyage[0]->getPlaceNbClass2()-1);
                }
                $placeClass2 += 1;
                $price += $voyage[0]->getPriceClass2();
            }
        }


        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $price*100,
                    'product_data' => [
                        'name' => 'Paiement de votre billet de train',
                        'images' => ["https://i.imgur.com/EHyR2nP.png"],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . 'home/success',
            'cancel_url' => $YOUR_DOMAIN . 'home/cancel',
        ]);
        $dataSession["payment_intent"] = $checkout_session["payment_intent"];
        $session->set('shopping', $dataSession);
        header("HTTP/1.1 303 See Other");

        return $this->redirect($checkout_session->url);
    }

    #[Route('/{id}', name: 'shopping_delete', methods: ['POST'])]
    public function delete(Request $request): Response
    {
        $id = $request->request->get('id');

        $session = $this->requestStack->getSession();
        $dataSession = $session->get('shopping');

        unset($dataSession[$id]);

        $session->set('shopping', $dataSession);

        $this->addFlash('green', "L'élément a été supprimé de votre panier");

        return $this->redirectToRoute('shopping', [], Response::HTTP_SEE_OTHER);
    }


}
