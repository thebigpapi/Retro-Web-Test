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
        return $this->render('misc/family/show.html.twig', [
            'family' => $family,
            'controller_name' => 'MiscController',
        ]);
    }

    #[Route('/sockets', name: 'socket_index')]
    public function indexSocket(Request $request, PaginatorInterface $paginator, CpuSocketRepository $cpuSocketRepository): Response {
        $data = $cpuSocketRepository->findAllSorted();
        $sockets = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            96
        );
        return $this->render('misc/socket/index.html.twig', [
            'sockets' => $sockets,
            'controller_name' => 'MiscController',
        ]);
    }

    #[Route('/sockets/{id}', name: 'socket_show', requirements: ['id' => '\d+'])]
    public function showSocket(int $id, CpuSocketRepository $cpuSocketRepository): Response {
        $socket = $cpuSocketRepository->find($id);

        if (!$socket) {
            throw $this->createNotFoundException(
                'No socket found for id ' . $id
            );
        }
        return $this->render('misc/socket/show.html.twig', [
            'socket' => $socket,
            'controller_name' => 'MiscController',
        ]);
    }

    #[Route('/power-connectors', name: 'power_connector_index')]
    public function indexPowerConnector(Request $request, PaginatorInterface $paginator, PSUConnectorRepository $psuConnectorRepository): Response {
        $data = $psuConnectorRepository->findAllSorted();
        $power = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            96
        );
        return $this->render('misc/power/index.html.twig', [
            'power_connectors' => $power,
            'controller_name' => 'MiscController',
        ]);
    }

    #[Route('/power-connectors/{id}', name: 'power_connector_show', requirements: ['id' => '\d+'])]
    public function showPowerConnector(int $id, PSUConnectorRepository $psuConnectorRepository): Response {
        $conn = $psuConnectorRepository->find($id);

        if (!$conn) {
            throw $this->createNotFoundException(
                'No PSU connector found for id ' . $id
            );
        }
        return $this->render('misc/power/show.html.twig', [
            'psu_connector' => $conn,
            'controller_name' => 'MiscController',
        ]);
    }

    #[Route('/io-ports', name: 'io_port_index')]
    public function indexIoPort(Request $request, PaginatorInterface $paginator, IoPortInterfaceSignalRepository $ioPortInterfaceSignalRepository): Response {
        $data = $ioPortInterfaceSignalRepository->findAllSorted();
        $conn = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            96
        );
        return $this->render('misc/port/index.html.twig', [
            'io_ports' => $conn,
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
        return $this->render('misc/port/show.html.twig', [
            'io_port' => $conn,
            'controller_name' => 'MiscController',
        ]);
    }

    #[Route('/expansion-slots', name: 'expansion_slot_index')]
    public function indexExpansionSlot(Request $request, PaginatorInterface $paginator, ExpansionSlotInterfaceSignalRepository $expansionSlotInterfaceSignalRepository): Response {
        $data = $expansionSlotInterfaceSignalRepository->findAllSorted();
        $slot = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            96
        );
        return $this->render('misc/slot/index.html.twig', [
            'expansion_slots' => $slot,
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
        return $this->render('misc/slot/show.html.twig', [
            'expansion_slot' => $conn,
            'controller_name' => 'MiscController',
        ]);
    }
}