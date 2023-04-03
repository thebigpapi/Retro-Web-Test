<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MotherboardRepository;
use App\Repository\MotherboardBiosRepository;
use App\Repository\ChipsetRepository;
use App\Repository\ProcessorRepository;
use App\Repository\LargeFileRepository;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    #[Route('/', name:'app_homepage')]
    public function index(MotherboardRepository $motherboardRepository, MotherboardBiosRepository $motherboardBiosRepository, ChipsetRepository $chipsetRepository, ProcessorRepository $cpuRepository, LargeFileRepository $largeFileRepository): Response
    {
        $latestMotherboards = $motherboardRepository->findLatest();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'latestMotherboards' => $latestMotherboards,
            'moboCount' => $motherboardRepository->getCount(),
            'chipCount' => $chipsetRepository->getCount(),
            'cpuCount' => $cpuRepository->getCount(),
            'biosCount' => $motherboardBiosRepository->getCount(),
            'driverCount' => $largeFileRepository->getCount(),
        ]);
    }

    #[Route('/info', name:'app_info')]
    public function info(): Response
    {
        return $this->render('main/info.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/info/credits', name:'app_credits')]
    public function credits(): Response
    {
        return $this->render('main/credits.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/info/contributions', name:'app_contributions')]
    public function contrib(): Response
    {
        return $this->render('main/contrib.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/info/legal', name:'app_legal')]
    public function legal(): Response
    {
        return $this->render('main/legal.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
