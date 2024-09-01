<?php

namespace App\Controller;

use App\Form\PowerConnector\Search;
use App\Repository\PSUConnectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;

class PowerConnectorController extends AbstractController
{
    #[Route('/power-connectors/{id}', name: 'power_connector_show', requirements: ['id' => '\d+'])]
    public function showPowerConnector(int $id, PSUConnectorRepository $psuConnectorRepository): Response {
        $conn = $psuConnectorRepository->find($id);

        if (!$conn) {
            throw $this->createNotFoundException(
                'No power connector found for id ' . $id
            );
        }
        return $this->render('power/show.html.twig', [
            'powerconn' => $conn,
            'controller_name' => 'MiscController',
        ]);
    }

    #[Route('/power-connectors/', name: 'powerconnsearch')]
    public function searchResultPowerConnector(Request $request, PaginatorInterface $paginator, PSUConnectorRepository $psuConnectorRepository): Response {
        $form = $this->_searchFormHandlerPowerConnector($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('powerconnsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaPowerConnector($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('power/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $data = $psuConnectorRepository->findByPowerConnector($criterias);
        $powerconns = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('power/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'PowerConnectorController',
            'powerconns' => $powerconns,
        ]);
    }

    #[Route('/power-connectors/live', name: 'powerconnlivewrapper')]
    public function liveSearchPowerConnector(Request $request): Response
    {
        $form = $this->_searchFormHandlerPowerConnector($request);
        return $this->redirect($this->generateUrl('powerconnlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/power-connectors/results', name: 'powerconnlivesearch')]
    public function liveResultsPowerConnector(Request $request, PaginatorInterface $paginator, PSUConnectorRepository $cpuPowerConnectorepository): Response
    {
        $criterias = $this->getCriteriaPowerConnector($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $cpuPowerConnectorepository->findByPowerConnector($criterias);
        $powerconns = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/power-connectors/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('power/result.html.twig', [
            'controller_name' => 'PowerConnectorController',
            'powerconns' => $powerconns,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaPowerConnector(Request $request){
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
    private function _searchFormHandlerPowerConnector(Request $request): FormInterface
    {
        $form = $this->createForm(Search::class, array(), []);
        $form->handleRequest($request);
        return $form;
    }
}