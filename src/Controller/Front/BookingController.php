<?php

namespace App\Controller\Front;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;



class BookingController extends AbstractController
{
    #[Route('/mesVoyages', name: 'mesVoyages', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        $userConnected = $this->get('security.token_storage')->getToken()->getUser();


        return $this->render('Front/trip/index.html.twig', [
            'bookings' => $bookingRepository->findBy(array('idUser' => $userConnected->getId())),
        ]);
    }

    #[Route('/{id}', name: 'booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        return $this->render('Front/trip/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('monVoyage/{id}', name: 'booking_facture', methods: ['GET'])]
    public function monVoyage(Booking $booking): Response
    {
        //dd($booking->getLineTrain()->getLine()->getNameStationArrival());
        $dompdf = new Dompdf();
        $html = '<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Facture Pa Express</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td valign="top"></td>
        <td align="right">
            <h3>PA Express</h3>
            <pre>
                Pa Express - paiement voyage
                75 Rue jean bleuzn
                Siret : 2132154321564653212354
                01 21 32 65 98
            </pre>
        </td>
    </tr>

  </table>

  <table width="100%">
    <tr>
        <td><strong>From: </strong>'.$booking->getLineTrain()->getLine()->getNameStationDeparture().'</td>
        <td><strong>To: </strong>'.$booking->getLineTrain()->getLine()->getNameStationArrival().'</td>
    </tr>
    <tr>
        <td><strong>Departure at: </strong>'.$booking->getLineTrain()->getTimeDeparture()->format('H:i').'</td>
        <td><strong>Arrival at: </strong>'.$booking->getLineTrain()->getTimeArrival()->format('H:i').'</td>
    </tr>

  </table>

  <br/>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Unit Price $</th>
      </tr>
    </thead>
    <tbody>
    ';

    for($i = 0; $i< sizeof($booking->getTravelers()); $i++){
        $html .= '<tr>';
        $html .= '<td align="right">' . $i+1 . '</td>';
        $html .= '<td align="right">' . $booking->getTravelers()[$i][0] . '</td>';
        $html .= '<td align="right">' . $booking->getTravelers()[$i][1] . '</td>';
        $html .= '<td align="right">' . number_format((float)$booking->getPrice()/sizeof($booking->getTravelers()), 2, '.', '') . '</td>';
        $html .= '</tr>';
    }
$html .= '
    </tbody>

    <tfoot>
        <tr>
            <td colspan="2"></td>
            <td align="right">Total $</td>
            <td align="right" class="gray">'. $booking->getPrice().'</td>
        </tr>
    </tfoot>
  </table>

</body>
</html>';
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'letter');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
        return $this->render('Front/trip/show.html.twig', [
            'booking' => $booking,
        ]);
    }
}
