<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use function Doctrine\Common\Cache\Psr6\set;

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
    public function searchTicket(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $entityManager->getRepository(LineTrain::class);

            $query = $repository->createQueryBuilder('lt')
                ->select('lt, line')
                ->leftJoin('lt.line', 'line')
                ->where('line.name_station_departure = :token')
                ->setParameters([
                    'token' => $request->request->get('token'),
                ]);


            $q = $query->getQuery();

            $travels = $q->execute();
        }
        return new JsonResponse(false);
    }
}