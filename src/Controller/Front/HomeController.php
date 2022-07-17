<?php

namespace App\Controller\Front;

use App\Entity\Booking;
use App\Entity\BookingSeat;
use App\Entity\LineTrain;
use App\Entity\Option;
use App\Entity\Seat;
use App\Entity\Wagon;
use App\Form\HomeType;
use App\Repository\BookingRepository;
use App\Repository\BookingSeatRepository;
use App\Repository\LineTrainRepository;
use App\Repository\SeatRepository;
use App\Repository\WagonRepository;
use DateTime;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use function Doctrine\Common\Cache\Psr6\set;
use function React\Promise\all;

#[Route('/')]
class HomeController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $session = $this->requestStack->getSession();
    }

    #[Route('/', name: 'home', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(HomeType::class);
        $form->handleRequest($request);

        $banner = 'png';

        if (file_exists('./img/banner.png')) {
            $banner = 'png';
        }elseif (file_exists('./img/banner.jpg')) {
            $banner = 'jpg';
        }

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(LineTrain::class);

        $query = $repository->createQueryBuilder('lt')
            ->select('lt, line')
            ->leftJoin('lt.line', 'line')
            ->where('lt.date_departure > :date_departure')
            ->setMaxResults(3)
            ->setParameters([
                'date_departure' => date("Y-m-d")
            ]);

        $q = $query->getQuery();

        $nextTravels = $q->execute();

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
                'noTravels' => $noTravels,
                'banner' => $banner,
                'nextTravels' => $nextTravels
            ]);

        }

        return $this->renderForm('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form,
            'travels' => false,
            'noTravels' => false,
            'banner' => $banner,
            'nextTravels' => $nextTravels
        ]);
    }

    #[Route('/shopping', name: 'shopping', methods: 'GET')]
    public function shopping(Request $request): Response
    {
        $session = $this->requestStack->getSession();
        $dataSession = $session->get('shopping');

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(LineTrain::class);

        $travels = [];
        $total = 0;
        $travelers = [];

        if($dataSession != null) {
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
                if ($value[1] === 1) {
                    $total += ($travel[0]->getPriceClass1())*count($value[2]);
                } else {
                    $total += ($travel[0]->getPriceClass2())*count($value[2]);
                }

                array_push($travelers, $value[2]);
            }
        }

        return $this->renderForm('Front/home/shopping.html.twig', [
            'controller_name' => 'HomeController',
            'travels' => $travels,
            'total' => $total,
            'travelers' => $travelers
        ]);
    }

    #[Route('/stations', name: 'stations', methods: 'GET')]
    public function getStations(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $json = file_get_contents("../templates/Front/home/stations.json");
            return new JsonResponse($json);
        }
        throw $this->createNotFoundException('Not exist');
    }

    #[Route('/add-option', name: 'addOption', methods: 'POST')]
    public function addOption(Request $request, LineTrainRepository $lineTrainRepository): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $id = intval($request->request->get('id'));
            $classWagon = intval($request->request->get('classWagon'));
            $travelers = $request->request->get('travelers');

            if (is_null($travelers) ||
                ($classWagon !== 1 && $classWagon !== 2) ||
                $id === 0) {
                return new JsonResponse(false);
            }

            $travel = $lineTrainRepository->findBy(['id' => $id]);

            if (count($travel) === 0) {
                return new JsonResponse(false);
            }

            $session = $this->requestStack->getSession();
            $dataSession = $session->get('shopping');

            if ($dataSession === null){
                $session->set('shopping', [[$id, $classWagon, $travelers]]);
            } else {
                array_push($dataSession, [$id, $classWagon, $travelers]);
                $session->set('shopping', $dataSession);
            }

            $session->get('shopping');

            return new JsonResponse(true);
        }
        throw $this->createNotFoundException('Not exist');
    }
    #[Route('/success', name: 'success', methods: ['GET','POST'])]
    public function success(Request $request, LineTrainRepository $lineTrainRepository,BookingRepository $bookingRepository, BookingSeatRepository $bookingSeatRepository, SeatRepository $seatRepository, WagonRepository $wagonRepository): Response
    {

        $session = $this->requestStack->getSession();
        $dataSession = $session->get('shopping');
        if ($dataSession== null){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }

        $stripe = new \Stripe\StripeClient(
            'sk_test_51Kk6uiCJ5s87DbRlsu9UTG7t0PbKcXlXM7bxLdibROOksHgDXIg1gXtp0SFv7o0MZxTcCTOLmEzjK1AVvdCR9LXg00vHipH4ZP'
        );

        $payment_intent = $stripe->paymentIntents->retrieve(
            $dataSession['payment_intent'],
            []
        );

        if ($payment_intent->status == "succeeded"){
            $userConnected = $this->get('security.token_storage')->getToken()->getUser();
            $session = $this->requestStack->getSession();
            $dataSession = $session->get('shopping');
            for ($i = 0; $i < sizeof($dataSession)-1; $i++) {
                $idVoyage = $dataSession[$i][0];
                $class = $dataSession[$i][1];
                $travelers = $dataSession[$i][2];
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
                $booking->setDateBooking(new DateTime());
                $booking->setTravelers($travelers);
                $booking->setToken($this->generateToken());
                $booking->setIdUser($userConnected);
                $booking->setPaymentIntent($dataSession["payment_intent"]);



                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($booking);
                $entityManager->flush();

                //Get all Booking
                $allBooking = new Booking();
                $allBooking = $bookingRepository->findBy(array("lineTrain" => $voyage[0]->getId()));

                $wagon = New Wagon();
                $wagon = $wagonRepository->findBy(array('train' => $voyage[0]->getTrain()->getId(), 'type' => 'Voyageur'));
                $wagonIdx = null;
                for ($i = 0; $i < sizeof($wagon); $i++){
                    $wagonIdx = $i;
                }
                if (sizeof($allBooking) < $wagon[$wagonIdx]->getPlaceNb()){
                    for( $i = 0; $i < sizeof($travelers); $i++){
                        $seat = New BookingSeat();
                        $seat->setBooking($booking);

                        $seat->setSeat($seatRepository->findOneBy(array("wagon" => $wagon[$wagonIdx]->getId(),"number" => sizeof($allBooking)+($i+1))));
                        $seat->setFirstname($travelers[$i][0]);
                        $seat->setLastname($travelers[$i][1]);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($seat);
                        $entityManager->flush();
                    }


                }else{
                    return $this->render('Front/home/error.html.twig');
                }
            }

            $session->remove('shopping');
            return $this->render('Front/home/success.html.twig');
        }else{
            // TU REDIRIGES VERS CANCEL
            return $this->render('Front/home/error.html.twig');

        }




    }

    #[Route('/payment', name: 'payment', methods: ['GET','POST'])]
    public function payment(Request $request, LineTrainRepository $lineTrainRepository): Response
    {

        $securityContext = $this->container->get('security.authorization_checker');

        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') === false) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->redirect("/login");
        }


        // This is your test secret API key.
        \Stripe\Stripe::setApiKey('sk_test_51Kk6uiCJ5s87DbRlsu9UTG7t0PbKcXlXM7bxLdibROOksHgDXIg1gXtp0SFv7o0MZxTcCTOLmEzjK1AVvdCR9LXg00vHipH4ZP');

        header('Content-Type: application/json');
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
            $protocol = "https";
        }else{
            $protocol = "http";
        }
        $YOUR_DOMAIN = $protocol.'://'.$_SERVER['SERVER_NAME'].'/';
        $session = $this->requestStack->getSession();
        $dataSession = $session->get('shopping');
        $price = 0;
        $placeClass1 = 0;
        $placeClass2 = 0;
        for ($i = 0; $i < sizeof($dataSession); $i++){
            $idVoyage = $dataSession[$i][0];
            $class = $dataSession[$i][1];
            $travelers = $dataSession[$i][2];

            $voyage = $lineTrainRepository->findBy(array('id' => $idVoyage));

            if ($class == '1'){
                if ($voyage[0]->getPlaceNbClass1()-1 < 0){
                    return $this->render('Front/home/error.html.twig');
                }else{
                    $voyage[0]->setPlaceNbClass1($voyage[0]->getPlaceNbClass1()-1);
                }
                $placeClass1 += 1;
                $price += ($voyage[0]->getPriceClass1()*count($travelers));
            }else if($class == '2'){
                if ($voyage[0]->getPlaceNbClass2()-1 < 0 || $voyage[0]->getPlaceNbClass2() == 0){
                    return $this->render('Front/home/error.html.twig');
                }else{
                    $voyage[0]->setPlaceNbClass2($voyage[0]->getPlaceNbClass2()-1);
                }
                $placeClass2 += 1;
                $price += ($voyage[0]->getPriceClass2()*count($travelers));
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
                        'images' => [],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . 'success',
            'cancel_url' => $YOUR_DOMAIN . 'cancel',
        ]);
        unset($dataSession["payment_intent"]);
        $dataSession["payment_intent"] = $checkout_session["payment_intent"];
        $session->set('shopping', $dataSession);
        header("HTTP/1.1 303 See Other");

        return $this->redirect($checkout_session->url);
    }

    #[Route('/delete-shopping/{id}', name: 'shopping_delete', methods: ['POST'])]
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
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(50)), '+/', '-_'), '=');
    }

}
