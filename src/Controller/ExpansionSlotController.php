<?php

namespace App\Controller;

use App\Form\ExpansionSlot\Search;
use App\Repository\ExpansionSlotInterfaceSignalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;

class ExpansionSlotController extends AbstractController
{
    #[Route('/expansion-slots/{id}', name: 'expansion_slot_show', requirements: ['id' => '\d+'])]
    public function showExpansionSlot(int $id, ExpansionSlotInterfaceSignalRepository $expansionSlotInterfaceSignalRepository): Response {
        $conn = $expansionSlotInterfaceSignalRepository->find($id);

        if (!$conn) {
            throw $this->createNotFoundException(
                'No expansion slot found for id ' . $id
            );
        }
        return $this->render('slot/show.html.twig', [
            'expansion_slot' => $conn,
            'controller_name' => 'ExpansionSlotController',
        ]);
    }

    #[Route('/expansion-slots/', name: 'expansionslotsearch')]
    public function searchResultExpansionSlot(Request $request, PaginatorInterface $paginator, ExpansionSlotInterfaceSignalRepository $expansionslotInterfaceSignalRepository): Response {
        $form = $this->_searchFormHandlerExpansionSlot($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('expansionslotsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaExpansionSlot($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('slot/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $data = $expansionslotInterfaceSignalRepository->findByExpansionSlot($criterias);
        $expansionslots = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('slot/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ExpansionSlotController',
            'expansionslots' => $expansionslots,
        ]);
    }

    #[Route('/expansion-slots/live', name: 'expansionslotlivewrapper')]
    public function liveSearchExpansionSlot(Request $request): Response
    {
        $form = $this->_searchFormHandlerExpansionSlot($request);
        return $this->redirect($this->generateUrl('expansionslotlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/expansion-slots/results', name: 'expansionslotlivesearch')]
    public function liveResultsExpansionSlot(Request $request, PaginatorInterface $paginator, ExpansionSlotInterfaceSignalRepository $expansionslotInterfaceSignalRepository): Response
    {
        $criterias = $this->getCriteriaExpansionSlot($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $expansionslotInterfaceSignalRepository->findByExpansionSlot($criterias);
        $expansionslots = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/expansion-slots/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('slot/result.html.twig', [
            'controller_name' => 'ExpansionSlotController',
            'expansionslots' => $expansionslots,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaExpansionSlot(Request $request){
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
    private function _searchFormHandlerExpansionSlot(Request $request): FormInterface
    {
        $form = $this->createForm(Search::class, array(), []);
        $form->handleRequest($request);
        return $form;
    }
}