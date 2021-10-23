<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MotherboardRepository;
use App\Entity\Motherboard;
use App\Entity\MotherboardBios;
use App\Repository\MotherboardBiosRepository;
use Symfony\Component\HttpKernel\KernelInterface;

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
    public function credits(KernelInterface $appKernel)
    {
        return $this->render('main/credits.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/change_page/", name="change_page"), methods={"GET"})
     * @param Request $request
     */
    public function changePage(Request $request)
    {
        if ($locale = $request->get('lang')) {
            $request->getSession()->set('_locale', $locale);
        }

        if ($url = $request->get('goto')) {
            return $this->redirect($url);
        }

        return $this->redirect('../');
    }
}
