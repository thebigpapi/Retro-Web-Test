<?php

namespace App\Controller;

use App\Entity\LargeFile;
use App\Form\Drivers\Search;
use App\Repository\LargeFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class DriversController extends AbstractController
{
    #[Route('/drivers/{id}', name:'driver_show', requirements:['id' => '\d+'])]
    public function showDriver(int $id, LargeFileRepository $driverRepository): Response
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
    public function searchResultDriver(Request $request, PaginatorInterface $paginator, LargeFileRepository $driverRepository): Response
    {
        $form = $this->_searchFormHandlerDrivers($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('driversearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaDriver($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if ($criterias == array()) {
            return $this->render('drivers/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        else{
            $data = $driverRepository->findByDriver($criterias);
            $drivers = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
            return $this->render('drivers/search.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'DriversController',
                'drivers' => $drivers,
            ]);
        }
    }
    #[Route('/drivers/live', name: 'driverlivewrapper')]
    public function liveSearchDriver(Request $request): Response
    {
        $form = $this->_searchFormHandlerDrivers($request);
        return $this->redirect($this->generateUrl('driverlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/drivers/results', name: 'driverlivesearch')]
    public function liveResultsDriver(Request $request, PaginatorInterface $paginator, LargeFileRepository $driverRepository): Response
    {
        $criterias = $this->getCriteriaDriver($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $driverRepository->findByDriver($criterias);
        $drivers = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/drivers/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('drivers/result.html.twig', [
            'controller_name' => 'DriversController',
            'drivers' => $drivers,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaDriver(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        return $criterias;
    }
    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();
        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['name'] = $form['name']->getData();
        return $parameters;
    }
    private function _searchFormHandlerDrivers(Request $request): FormInterface
    {
        $form = $this->createForm(Search::class, array(), []);
        $form->handleRequest($request);
        return $form;
    }

    #[Route('/drivers/index/{letter}', name:'driverindex', requirements:['letter' => '\w|[?]'], methods:["GET"])]
    public function indexDriver(Request $request, PaginatorInterface $paginator, string $letter, LargeFileRepository $driverRepository): Response
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
