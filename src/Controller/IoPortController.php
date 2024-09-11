<?php

namespace App\Controller;

use App\Form\IoPort\Search;
use App\Repository\IoPortInterfaceSignalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;

class IoPortController extends AbstractController
{
    #[Route('/io-ports/{id}', name: 'io_port_show', requirements: ['id' => '\d+'])]
    public function showIoPort(int $id, IoPortInterfaceSignalRepository $ioPortInterfaceSignalRepository): Response {
        $conn = $ioPortInterfaceSignalRepository->find($id);

        if (!$conn) {
            throw $this->createNotFoundException(
                'No I/O port found for id ' . $id
            );
        }
        return $this->render('port/show.html.twig', [
            'io_port' => $conn,
            'controller_name' => 'IoPortController',
        ]);
    }

    #[Route('/io-ports/', name: 'ioportsearch')]
    public function searchResultIoPort(Request $request, PaginatorInterface $paginator, IoPortInterfaceSignalRepository $ioPortInterfaceSignalRepository): Response {
        $form = $this->_searchFormHandlerIoPort($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('ioportsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaIoPort($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('port/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $data = $ioPortInterfaceSignalRepository->findByIoPort($criterias);
        $ioports = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('port/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'IoPortController',
            'ioports' => $ioports,
        ]);
    }

    #[Route('/io-ports/live', name: 'ioportlivewrapper')]
    public function liveSearchIoPort(Request $request): Response
    {
        $form = $this->_searchFormHandlerIoPort($request);
        return $this->redirect($this->generateUrl('ioportlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/io-ports/results', name: 'ioportlivesearch')]
    public function liveResultsIoPort(Request $request, PaginatorInterface $paginator, IoPortInterfaceSignalRepository $ioPortInterfaceSignalRepository): Response
    {
        $criterias = $this->getCriteriaIoPort($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $ioPortInterfaceSignalRepository->findByIoPort($criterias);
        $ioports = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/io-ports/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('port/result.html.twig', [
            'controller_name' => 'IoPortController',
            'ioports' => $ioports,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaIoPort(Request $request){
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
    private function _searchFormHandlerIoPort(Request $request): FormInterface
    {
        $form = $this->createForm(Search::class, array(), []);
        $form->handleRequest($request);
        return $form;
    }
}