<?php

namespace App\Controller;

use App\Repository\ChipsetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChipsetController extends AbstractController
{
    /**
     * @Route("/chipsets", name="chipset")
     */
    public function index(): Response
    {
        return $this->render('chipset/index.html.twig', [
            'controller_name' => 'ChipsetController',
        ]);
    }
    /**
     * @Route("/chipsets/{id}", name="chipset_show", requirements={"id"="\d+"})
     */
    public function show(int $id, ChipsetRepository $chipsetRepository)
    {
        $chipset = $chipsetRepository->find($id);

        return $this->render('chipset/show.html.twig', [
            'chipset' => $chipset,
            'controller_name' => 'ChipsetController',
        ]);
    }
}
