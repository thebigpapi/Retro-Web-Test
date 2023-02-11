<?php

namespace App\Controller;

use App\Entity\LargeFile;
use App\Form\Drivers\Search;
use App\Repository\LargeFileRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class DriversController extends AbstractController
{
    #[Route('/drivers/{id}', name:'driver_show', requirements:['id' => '\d+'])]
    public function show(int $id, LargeFileRepository $driverRepository): Response
    {
        $driver = $driverRepository->find($id);
        if (!$driver) {
            throw $this->createNotFoundException(
                'No $driver found for id ' . $id
            );
        } else {
            return $this->render('drivers/show.html.twig', [
                'driver' => $driver,
                'controller_name' => 'DriversController',
            ]);
        }
    }

    #[Route('/drivers/', name:'driversearch', methods:['GET'])]
    public function searchResult(Request $request, PaginatorInterface $paginator, LargeFileRepository $driverRepository): Response
    {
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }

        if ($criterias == array()) {
            return $this->redirectToRoute('driver_search');
        }

        try {
            $data = $driverRepository->findByDriver($criterias);
        } catch (Exception $e) {
            return $this->redirectToRoute('driver_search');
        }
        $drivers = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('drivers/result.html.twig', [
            'controller_name' => 'DriversController',
            'drivers' => $drivers,
            'driver_count' => count($data),
        ]);
    }

    #[Route('/drivers/search/', name:'driver_search')]
    public function search(Request $request, LargeFileRepository $driverRepository): Response
    {
        $latestDrivers = $driverRepository->findLatest();
        $form = $this->createForm(Search::class, array());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('driversearch', ['name' => $form['name']->getData()]));
        }
        return $this->render('drivers/search.html.twig', [
            'latestDrivers' => $latestDrivers,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/drivers/index/{letter}', name:'driverindex', requirements:['letter' => '\w|[?]'], methods:["GET"])]
    public function index(Request $request, PaginatorInterface $paginator, string $letter, LargeFileRepository $driverRepository): Response
    {
        if ($letter === "?") {
            $letter = "";
        }
        $data = $driverRepository->findAllAlphabetic($letter);

        usort(
            $data,
            function (LargeFile $a, LargeFile $b) {
                return strcmp($a->getName(), $b->getName());
            }
        );

        $drivers = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('drivers/index.html.twig', [
            'drivers' => $drivers,
            'driver_count' => count($data),
            'letter' => $letter,
        ]);
    }
}
