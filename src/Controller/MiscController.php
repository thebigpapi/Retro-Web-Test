<?php

namespace App\Controller;

use App\Repository\CpuSocketRepository;
use App\Repository\IoPortInterfaceSignalRepository;
use App\Repository\ExpansionSlotInterfaceSignalRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\ProcessorPlatformTypeRepository;
use App\Repository\PSUConnectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class MiscController extends AbstractController
{
    #[Route('/family/{id}', name: 'family_show', requirements: ['id' => '\d+'])]
    public function showFamily(int $id, ProcessorPlatformTypeRepository $processorPlatformTypeRepository): Response {
        $family = $processorPlatformTypeRepository->find($id);

        if (!$family) {
            throw $this->createNotFoundException(
                'No family found for id ' . $id
            );
        }
        return $this->render('family/show.html.twig', [
            'family' => $family,
            'controller_name' => 'MiscController',
        ]);
    }
}