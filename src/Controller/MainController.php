<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MotherboardRepository;
use App\Repository\MotherboardBiosRepository;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(MotherboardRepository $motherboardRepository, MotherboardBiosRepository $motherboardBiosRepository)
    {
        $latestMotherboards = $motherboardRepository->find10Latest();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'latestMotherboards' => $latestMotherboards,
            'moboCount' => $motherboardRepository->getCount(),
            'biosCount' => $motherboardBiosRepository->getCount(),
        ]);
    }

    /**
     * @Route("/credits", name="app_credits")
     */
    public function credits()
    {
        return $this->render('main/credits.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
