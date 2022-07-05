<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\BookingRepository;
use App\Entity\Booking;



#[Route('/qrcode')]
class QrCodeController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $session = $this->requestStack->getSession();
    }

    #[Route('/', name: 'qrcode', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        return $this->renderForm('Front/qr_code/index.html.twig', [
            'controller_name' => 'QrCodeController'
        ]);
    }

    #[Route('/search', name: 'qrcode-search', methods: ['GET', 'POST'])]
    public function searchTicket(Request $request, BookingRepository $bookingRepository): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(Booking::class);

            $query = $repository->createQueryBuilder('booking')
                ->select('booking, lineTrain, line')
                ->leftJoin('booking.lineTrain', 'lineTrain')
                ->leftJoin('lineTrain.line', 'line')
                ->where('booking.token = :token')
                ->setParameters([
                    'token' => $request->request->get('token')
                ]);

            $q = $query->getQuery();

            $booking = $q->execute();

            if (count($booking) === 0){
                return new JsonResponse(false);
            }

            $result = [];

            array_push($result, $booking[0]->getTravelers());
            array_push($result, $booking[0]->getLineTrain()->getDateDeparture());
            array_push($result, $booking[0]->getLineTrain()->getTrain()->getName());
            array_push($result, $booking[0]->getLineTrain()->getLine()->getNameStationDeparture());
            array_push($result, $booking[0]->getLineTrain()->getLine()->getNameStationArrival());
            array_push($result, $booking[0]->getLineTrain()->getTimeDeparture());
            array_push($result, $booking[0]->getLineTrain()->getTimeArrival());


            return new JsonResponse(json_encode($result));
        }
        throw $this->createNotFoundException('Not exist');
    }
}