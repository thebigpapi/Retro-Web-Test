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

class MiscController extends AbstractController
{
    #[Route('/cpufamily/{id}', name: 'cpufamily_show', requirements: ['id' => '\d+'])]
    public function showFamily(int $id, ProcessorPlatformTypeRepository $processorPlatformTypeRepository): Response {
        $family = $processorPlatformTypeRepository->find($id);

        if (!$family) {
            throw $this->createNotFoundException(
                'No CPU family found for id ' . $id
            );
        }
        return $this->render('misc/cpufamily.html.twig', [
            'family' => $family,
            'controller_name' => 'MiscController',
        ]);
    }
    #[Route('/cpusocket/{id}', name: 'cpusocket_show', requirements: ['id' => '\d+'])]
    public function showSocket(int $id, CpuSocketRepository $cpuSocketRepository): Response {
        $socket = $cpuSocketRepository->find($id);

        if (!$socket) {
            throw $this->createNotFoundException(
                'No CPU socket found for id ' . $id
            );
        }
        return $this->render('misc/cpusocket.html.twig', [
            'socket' => $socket,
            'controller_name' => 'MiscController',
        ]);
    }
    #[Route('/psu-connector/{id}', name: 'psu_connector_show', requirements: ['id' => '\d+'])]
    public function showPsuConnector(int $id, PSUConnectorRepository $psuConnectorRepository): Response {
        $conn = $psuConnectorRepository->find($id);

        if (!$conn) {
            throw $this->createNotFoundException(
                'No PSU connector found for id ' . $id
            );
        }
        return $this->render('misc/psu_connector.html.twig', [
            'psu_connector' => $conn,
            'controller_name' => 'MiscController',
        ]);
    }
    #[Route('/manufacturer/{id}', name: 'manufacturer_show', requirements: ['id' => '\d+'])]
    public function showManufacturer(int $id, ManufacturerRepository $manufacturerRepository): Response {
        $manuf = $manufacturerRepository->find($id);

        if (!$manuf) {
            throw $this->createNotFoundException(
                'No manufacturer found for id ' . $id
            );
        }
        return $this->render('misc/manufacturer.html.twig', [
            'manufacturer' => $manuf,
            'controller_name' => 'MiscController',
        ]);
    }
    #[Route('/io-ports/{id}', name: 'io_port_show', requirements: ['id' => '\d+'])]
    public function showIoPort(int $id, IoPortInterfaceSignalRepository $ioPortInterfaceSignalRepository): Response {
        $conn = $ioPortInterfaceSignalRepository->find($id);

        if (!$conn) {
            throw $this->createNotFoundException(
                'No I/O port found for id ' . $id
            );
        }
        return $this->render('misc/io_port.html.twig', [
            'io_port' => $conn,
            'controller_name' => 'MiscController',
        ]);
    }
    #[Route('/expansion-slots/{id}', name: 'expansion_slot_show', requirements: ['id' => '\d+'])]
    public function showExpansionSlot(int $id, ExpansionSlotInterfaceSignalRepository $expansionSlotInterfaceSignalRepository): Response {
        $conn = $expansionSlotInterfaceSignalRepository->find($id);

        if (!$conn) {
            throw $this->createNotFoundException(
                'No expansion slot found for id ' . $id
            );
        }
        return $this->render('misc/expansion_slot.html.twig', [
            'expansion_slot' => $conn,
            'controller_name' => 'MiscController',
        ]);
    }
}