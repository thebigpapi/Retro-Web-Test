<?php

namespace App\Controller;

use App\Form\Manufacturer\Search;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;

class ManufacturerController extends AbstractController
{
    #[Route('/manufacturers/{id}', name: 'manufacturer_show', requirements: ['id' => '\d+'])]
    public function showManufacturer(int $id, ManufacturerRepository $manufacturerRepository): Response {
        $manuf = $manufacturerRepository->find($id);

        if (!$manuf) {
            throw $this->createNotFoundException(
                'No manufacturer found for id ' . $id
            );
        }
        return $this->render('manufacturer/show.html.twig', [
            'manufacturer' => $manuf,
            'controller_name' => 'ManufacturerController',
        ]);
    }

    #[Route('/manufacturers/', name: 'manufacturersearch')]
    public function searchResultManufacturer(Request $request, PaginatorInterface $paginator, ManufacturerRepository $manufacturerRepository): Response {
        $latestManufacturers = $manufacturerRepository->findLatest(8);
        $form = $this->_searchFormHandlerManufacturer($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('manufacturersearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaManufacturer($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('manufacturer/search.html.twig', [
                'form' => $form->createView(),
                'latestManufacturers' => $latestManufacturers,
            ]);
        }

        $data = $manufacturerRepository->findByManufacturer($criterias);
        $manufs = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('manufacturer/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ManufacturerController',
            'manufacturers' => $manufs,
        ]);
    }

    #[Route('/manufacturers/live', name: 'manufacturerlivewrapper')]
    public function liveSearchManufacturer(Request $request): Response
    {
        $form = $this->_searchFormHandlerManufacturer($request);
        return $this->redirect($this->generateUrl('manufacturerlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/manufacturers/results', name: 'manufacturerlivesearch')]
    public function liveResultsManufacturer(Request $request, PaginatorInterface $paginator, ManufacturerRepository $manufacturerRepository): Response
    {
        $criterias = $this->getCriteriaManufacturer($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $manufacturerRepository->findByManufacturer($criterias);
        $manufacturers = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/manufacturers/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('manufacturer/result.html.twig', [
            'controller_name' => 'ManufacturerController',
            'manufacturers' => $manufacturers,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaManufacturer(Request $request){
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
    private function _searchFormHandlerManufacturer(Request $request): FormInterface
    {
        $form = $this->createForm(Search::class, array(), []);
        $form->handleRequest($request);
        return $form;
    }
}