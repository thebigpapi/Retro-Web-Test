<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\ExpansionCard\Search;
use App\Repository\ExpansionCardRepository;
use App\Repository\ExpansionCardTypeRepository;
use App\Repository\ExpansionChipTypeRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\ExpansionCardIdRedirectionRepository;
use App\Repository\ExpansionSlotInterfaceSignalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

class ExpansionCardController extends AbstractController
{
    #[Route('/expansioncards/{id}', name: 'expansioncard_show', requirements: ['id' => '\d+'])]
    public function show(
        int $id,
        ExpansionCardRepository $expansionCardRepository,
        ExpansionCardIdRedirectionRepository $expansionCardIdRedirectionRepository,
    ): Response {
        $expansionCard = $expansionCardRepository->find($id);

        if (!$expansionCard) {
            $idRedirection = $expansionCardIdRedirectionRepository->findRedirection($id, 'uh19');

            if (!$idRedirection) {
                throw $this->createNotFoundException(
                    'No expansion card found for id ' . $id
                );
            } else {
                return $this->redirect($this->generateUrl('expansioncard_show', array("id" => $idRedirection)));
            }
        }

        return $this->redirect($this->generateUrl('expansioncard_show_slug', array("slug" => $expansionCard->getSlug())));
    }
    #[Route('/expansioncards/s/{slug}', name: 'expansioncard_show_slug')]
    public function showSlug(
        string $slug,
        ExpansionCardRepository $expansionCardRepository,
        ExpansionCardIdRedirectionRepository $expansionCardIdRedirectionRepository,
        ExpansionChipTypeRepository $expansionChipTypeRepository
    ): Response {
        $expansionCard = $expansionCardRepository->findSlug($slug);
        $expansionchiptype = $expansionChipTypeRepository->findAll();

        if (!$expansionCard) {
            $idRedirection = $expansionCardIdRedirectionRepository->findRedirection($slug, 'uh19_slug');

            if (!$idRedirection) {
                throw $this->createNotFoundException(
                    'No expansion card found for slug ' . $slug
                );
            } else {
                return $this->redirect($this->generateUrl('expansioncard_show', array("id" => $idRedirection)));
            }
        }

        return $this->render('expansioncard/show.html.twig', [
            'expansioncard' => $expansionCard,
            'expansionchiptype' => $expansionchiptype,
            'controller_name' => 'ExpansionCardController',
        ]);
    }
    public function addCriteriaById(Request $request, array &$criterias, string $htmlId, string $sqlId): void
    {
        $entityId = htmlentities($request->query->get($htmlId) ?? ($request->request->get($htmlId) ?? ''));
        if ($entityId && intval($entityId)) $criterias[$sqlId] = "$entityId";
        elseif ($entityId === "NULL") $criterias[$sqlId] = null;
    }

    public function addArrayCriteria(Request $request, array &$criterias, string $htmlId, string $sqlId): void
    {
        $entityIds = $request->query->all($htmlId) ?? $request->request->all($htmlId);
        $entityArray = null;
        if ($entityIds) {
            if (is_array($entityIds)) {
                $entityArray = $entityIds;
            } else {
                $entityArray = json_decode($entityIds);
            }
            $criterias[$sqlId] = $entityArray;
        }
    }
    public function getCriteriaExpansionCard(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) $criterias['name'] = "$name";
        $this->addCriteriaById($request, $criterias, 'manufacturerId', 'manufacturer');
        $this->addCriteriaById($request, $criterias, 'cardExpansionSlotId', 'cardExpansionSlot');
        $this->addArrayCriteria($request, $criterias, 'cardTypeIds', 'cardTypes');
        $this->addArrayCriteria($request, $criterias, 'cardIoPortIds', 'cardIoPorts');
        $this->addArrayCriteria($request, $criterias, 'expansionChipIds', 'expansionChips');
        $this->addArrayCriteria($request, $criterias, 'dramTypeIds', 'dramTypes');
        return $criterias;
    }
    #[Route(path: '/expansioncards/', name: 'expansioncardsearch', methods: ['GET'])]
    public function searchResultExpansionCard(
        Request $request,
        PaginatorInterface $paginator,
        ExpansionCardRepository $expansionCardRepository,
        ManufacturerRepository $manufacturerRepository,
        ExpansionCardTypeRepository $expansionCardTypeRepository,
        ExpansionSlotInterfaceSignalRepository $expansionSlotInterfaceSignalRepository
        )
    {
        $latestCards = $expansionCardRepository->findLatest(8);
        $form = $this->_searchFormHandlerExpansionCard($request, $manufacturerRepository, $expansionCardTypeRepository, $expansionSlotInterfaceSignalRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('expansioncardsearch', $this->searchFormToParamExpansionCard($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaExpansionCard($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('expansioncard/search.html.twig', [
                'form' => $form->createView(),
                'latestCards' => $latestCards,
            ]);
        }
        $data = $expansionCardRepository->findByWithJoin($criterias);
        $expansionCards = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('expansioncard/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ExpansionCardController',
            'expansioncards' => $expansionCards,
        ]);

    }

    #[Route('/expansioncards/live', name: 'expansioncardlivewrapper')]
    public function liveSearchExpansionChip(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        ExpansionCardTypeRepository $expansionCardTypeRepository,
        ExpansionSlotInterfaceSignalRepository $expansionSlotInterfaceSignalRepository
    ): Response {
        $form = $this->_searchFormHandlerExpansionCard($request, $manufacturerRepository, $expansionCardTypeRepository, $expansionSlotInterfaceSignalRepository);

        return $this->redirect($this->generateUrl('expansioncardlivesearch', $this->searchFormToParamExpansionCard($request, $form)));
    }

    #[Route('/expansioncards/results', name: 'expansioncardlivesearch')]
    public function liveResultsExpansionCard(
        Request $request,
        PaginatorInterface $paginator,
        ExpansionCardRepository $expansionCardRepository
    ): Response {
        $criterias = $this->getCriteriaExpansionCard($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $expansionCardRepository->findByWithJoin($criterias);
        $expansionCards = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/expansioncards/?";
        foreach ($request->query as $key => $value){
            if($key == "cardIoPortIds"){
                foreach($value as $idx => $property){
                    foreach($property as $type=> $val){
                        $string .= $key . '%5B' . $idx . '%5D%5B' . $type . '%5D=' . $val .'&';
                    }
                }
            }
            else if($key == "cardTypeIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else if($key == "expansionChipIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else if($key == "dramTypeIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else{
                if($key != "domTarget")
                    $string .= $key . '=' . $value . '&';
            }
        }
        return $this->render('expansioncard/result.html.twig', [
            'controller_name' => 'ExpansionCardController',
            'expansioncards' => $expansionCards,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    private function searchFormToParamExpansionCard(Request $request, $form): array
    {
        $parameters = array();
        if ($form['manufacturer']->getData()) {
            if ($form['manufacturer']->getData()->getId() == 0) {
                $parameters['manufacturerId']  = "NULL";
            } else {
                $parameters['manufacturerId'] = $form['manufacturer']->getData()->getId();
            }
        }
        if ($form['cardExpansionSlot']->getData()) {
            if ($form['cardExpansionSlot']->getData()->getId() == 0) {
                $parameters['cardExpansionSlotId']  = "NULL";
            } else {
                $parameters['cardExpansionSlotId'] = $form['cardExpansionSlot']->getData()->getId();
            }
        }

        $ports = $form['cardIoPorts']->getData();
        if ($ports) {
            $parameters['cardIoPortIds'] = array();
            $loopCount = 0;
            foreach ($ports as $port) {
                if($loopCount >= 6)
                    break;
                $loopCount++;
                $countArray = $this->convertCount($port['count']);
                if ($countArray['value'] !== 0) {
                    $portCount = array('id' => $port['io_port']->getId(), 'count' => $countArray['value'], 'sign' => $countArray['sign']);
                    array_push($parameters['cardIoPortIds'], $portCount);
                } elseif ($countArray['value']== 0) {
                    $portCount = array('id' => $port['io_port']->getId(), 'count' => null, 'sign' => '=');
                    array_push($parameters['cardIoPortIds'], $portCount);
                }
            }
        }
        $expchips = $form['expansionChips']->getData();
        if ($expchips) {
            $parameters['expansionChipIds'] = array();
            $loopCount = 0;
            foreach ($expchips as $chip) {
                if($loopCount >= 6)
                    break;
                if($chip != null)
                    array_push($parameters['expansionChipIds'], $chip->getId());
            }
        }
        $types = $form['cardTypes']->getData();
        if ($types) {
            $parameters['cardTypeIds'] = array();
            $loopCount = 0;
            foreach ($types as $type) {
                if($loopCount >= 6)
                    break;
                if($type != null)
                    array_push($parameters['cardTypeIds'], $type->getId());
            }
        }
        $dramtypes = $form['dramTypes']->getData();
        if ($dramtypes) {
            $parameters['dramTypeIds'] = array();
            foreach ($dramtypes as $type) {
                array_push($parameters['dramTypeIds'], $type->getId());
            }
        }

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }
    private function _searchFormHandlerExpansionCard(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        ExpansionCardTypeRepository $expansionCardTypeRepository,
        ExpansionSlotInterfaceSignalRepository $expansionSlotInterfaceSignalRepository
    ): FormInterface {
        $expansionCardManufacturers = $manufacturerRepository->findAllExpansionCardManufacturer();
        $expansionCardTypes = $expansionCardTypeRepository->findAll();
        $expansionCardExpansionSlots = $expansionSlotInterfaceSignalRepository->findAll();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($expansionCardManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'expansionCardManufacturers' => $expansionCardManufacturers,
            'expansionCardTypes' => $expansionCardTypes,
            'expansionCardExpansionSlots' => $expansionCardExpansionSlots,
        ]);

        $form->handleRequest($request);

        return $form;
    }
    public function convertCount($input): array
    {
        $output = array();
        $output['valid'] = true;
        $nospaces = html_entity_decode(preg_replace("/\s+/", "", $input));
        $sign = preg_replace('/[^><=]/', '', $nospaces);
        $numbers = preg_replace('/[^0-9]/', '', $nospaces);
        if($numbers == "")
            $output['valid'] = false;
        $output['value'] = (int)$numbers;
        $output['sign'] = '=';
        if($sign == "<")
            $output['sign'] = '<';
        if($sign == ">")
            $output['sign'] = '>';
        if($sign == ">=")
            $output['sign'] = '>=';
        if($sign == "<=")
            $output['sign'] = '<=';
        return $output;
    }
}
