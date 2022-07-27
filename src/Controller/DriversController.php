<?php

namespace App\Controller;

use App\Form\Drivers\Search;
use App\Repository\LargeFileRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DriversController extends AbstractController
{
    /**
     * @Route("/drivers/{id}", name="driver_show", requirements={"id"="\d+"})
     */
    public function show(int $id, LargeFileRepository $driverRepository)
    {
        $driver = $driverRepository->find($id);
        if (!$driver) {
            throw $this->createNotFoundException(
                'No $driver found for id ' . $id
            );
        }
        else{
            return $this->render('drivers/show.html.twig', [
                'driver' => $driver,
                'controller_name' => 'DriversController',
            ]);
        }
    }

    /**
     * @Route("/drivers/", name="driversearch", methods={"GET"})
     * @param Request $request
     */
    public function searchResult(Request $request, PaginatorInterface $paginator, LargeFileRepository $driverRepository)
    {
        $criterias = array();
        $name = htmlentities($request->query->get('name'));
        if ($name) $criterias['name'] = "$name";

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

    /**
     * @Route("/drivers/search/", name="driver_search")
     * @param Request $request
     */
    public function search(Request $request, TranslatorInterface $translator)
    {
        $notIdentifiedMessage = $translator->trans("Not identified");



        $form = $this->createForm(Search::class, array(), [

        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('driversearch', $this->searchFormToParam($request, $form)));
        }
        return $this->render('drivers/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();
        $parameters['name'] = $form['name']->getData();
        return $parameters;
    }

    /**
     * @Route("/drivers/index/{letter}", name="driverindex", requirements={"letter"="\w|[?]"}), methods={"GET"})
     * @param Request $request
     */
    public function index(Request $request, PaginatorInterface $paginator, string $letter, LargeFileRepository $driverRepository)
    {
        if ($letter == "?") $letter = "";
        $data = $driverRepository->findAllAlphabetic($letter);

        usort(
            $data,
            function ($a, $b) {
                if ($a->getName() == $b->getName()) {
                    return 0;
                }
                return ($a->getName() < $b->getName()) ? -1 : 1;
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
