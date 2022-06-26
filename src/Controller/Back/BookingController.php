<?php

namespace App\Controller\Back;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/booking')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'booking', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('Back/booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    #[Route('/info', name: 'get_booking', methods: 'POST')]
    public function getBooking(Request $request, BookingRepository $bookingRepository): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $array = [];

            $id = intval($request->request->get('id'));

            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(Booking::class);

            $query = $repository->createQueryBuilder('b')
                ->select('b, lineTrain, line')
                ->leftJoin('b.lineTrain', 'lineTrain')
                ->leftJoin('lineTrain.line', 'line')
                ->where('b.id = :id')
                ->setParameters([
                    'id' => $id
                ]);

            $q = $query->getQuery();

            $booking = $q->execute();

            array_push($array, $booking[0]->getPrice());
            array_push($array, $booking[0]->getTravelers());
            array_push($array, $booking[0]->getLineTrain()->getDateDeparture());
            array_push($array, $booking[0]->getLineTrain()->getTimeDeparture());
            array_push($array, $booking[0]->getLineTrain()->getTimeArrival());
            array_push($array, $booking[0]->getLineTrain()->getLine()->getNameStationDeparture());
            array_push($array, $booking[0]->getLineTrain()->getLine()->getNameStationArrival());

            return new JsonResponse($array);
        }
        return new JsonResponse(false);
    }

    #[Route('/{id}', name: 'delete_booking', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();

            $booking->setStatus(-1);
            $stripe = new \Stripe\StripeClient(
                'sk_test_51Kk6uiCJ5s87DbRlsu9UTG7t0PbKcXlXM7bxLdibROOksHgDXIg1gXtp0SFv7o0MZxTcCTOLmEzjK1AVvdCR9LXg00vHipH4ZP'
            );
            $stripe->refunds->create([
                'payment_intent' => $booking->getPaymentIntent(),
            ]);
            $entityManager->persist($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking', [], Response::HTTP_SEE_OTHER);
    }
}
