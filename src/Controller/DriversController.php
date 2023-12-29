<?php

namespace App\Controller;

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
        if (empty($criterias)) {
            return $this->render('drivers/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }
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
            if($key == "osFlagIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else{
                if($key != "domTarget")
                    $string .= $key . '=' . $value . '&';
            }
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
        $osIds = $request->query->get('osFlagIds') ?? $request->request->get('osFlagIds');
        $chipArray = null;
        if ($osIds) {
            if (is_array($osIds)) {
                $chipArray = $osIds;
            } else {
                $chipArray = json_decode($osIds);
            }
            $criterias['osFlags'] = $chipArray;
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
        $osFlags = $form['osFlags']->getData();
        if ($osFlags) {
            $parameters['osFlagIds'] = array();
            foreach ($osFlags as $os) {
                if($os != null)
                    array_push($parameters['osFlagIds'], $os->getId());
            }
        }
        return $parameters;
    }
    private function _searchFormHandlerDrivers(Request $request): FormInterface
    {
        $form = $this->createForm(Search::class, array(), []);
        $form->handleRequest($request);
        return $form;
    }
}
