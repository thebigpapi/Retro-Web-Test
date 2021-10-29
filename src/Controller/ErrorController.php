<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function show(FlattenException $exception): Response
    {
        return $this->render('error/error.html.twig', [
            'controller_name' => 'ErrorController',
            'code' => $exception->getStatusCode(),
            'codeText' => $exception->getStatusText(),
            'message' => $exception->getMessage(),
        ]);
    }
}
