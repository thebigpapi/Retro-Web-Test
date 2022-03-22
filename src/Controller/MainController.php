<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MotherboardRepository;
use App\Repository\MotherboardBiosRepository;
use App\Repository\ChipsetRepository;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @param Request $request
     */
    public function index(MotherboardRepository $motherboardRepository)
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/hardware", name="app_hardware")
     */
    public function hardware(MotherboardRepository $motherboardRepository, MotherboardBiosRepository $motherboardBiosRepository, ChipsetRepository $chipsetRepository)
    {
        $latestMotherboards = $motherboardRepository->find10Latest();
        return $this->render('hardware/index.html.twig', [
            'controller_name' => 'MainController',
            'latestMotherboards' => $latestMotherboards,
            'moboCount' => $motherboardRepository->getCount(),
            'chipCount' => $chipsetRepository->getCount(),
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
