<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{
    public function show($exception): Response
    {
        return $this->render('bundles/TwigBundle/Exception/error.html.twig', [
            'message_exception' => $exception->getMessage(),
            'status_exception' => $exception->getStatusCode(),
            'statusText_exception' => $exception->getStatusText(),
        ]);
    }
}