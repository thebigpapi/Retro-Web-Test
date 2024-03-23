<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\ExpansionCard\Search;
use App\Repository\ExpansionCardRepository;
use App\Repository\ExpansionCardTypeRepository;
use App\Repository\ExpansionChipTypeRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\ExpansionCardIdRedirectionRepository;
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
    #[Route(path: '/expansioncards/', name: 'expansioncardsearch', methods: ['GET'])]
    public function searchResultExpansionCard(Request $request, PaginatorInterface $paginator, ExpansionCardRepository $expansionCardRepository, ManufacturerRepository $manufacturerRepository, ExpansionCardTypeRepository $expansionCardTypeRepository)
    {
        $latestCards = $expansionCardRepository->findLatest(8);
        $form = $this->_searchFormHandlerExpansionCard($request, $manufacturerRepository, $expansionCardTypeRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('expansioncardsearch', $this->searchFormToParamExpansionCard($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaExpansionCard($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('expansioncard/search.html.twig', [
                'form' => $form->createView(),
                'latestCards' => $latestCards,
            ]);
        }
        $data = $expansionCardRepository->findByExpansionCard($criterias);
        $expansionCards = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('expansioncard/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ExpansionCardController',
            'expansioncards' => $expansionCards,
            'show_images' => $showImages,
        ]);

    }

    #[Route('/expansioncards/live', name: 'expansioncardlivewrapper')]
    public function liveSearchExpansionChip(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        ExpansionCardTypeRepository $expansionCardTypeRepository
    ): Response {
        $form = $this->_searchFormHandlerExpansionCard($request, $manufacturerRepository, $expansionCardTypeRepository);

        return $this->redirect($this->generateUrl('expansioncardlivesearch', $this->searchFormToParamExpansionCard($request, $form)));
    }

    #[Route('/expansioncards/results', name: 'expansioncardlivesearch')]
    public function liveResultsExpansionCard(
        Request $request,
        PaginatorInterface $paginator,
        ExpansionCardRepository $expansionCardRepository
    ): Response {
        $criterias = $this->getCriteriaExpansionCard($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $expansionCardRepository->findByExpansionCard($criterias);
        $expansionCards = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/expansioncards/?";
        foreach ($request->query as $key => $value){
            if($key == "expansionChipIds"){
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
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaExpansionCard(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $chipIds = $request->query->all('expansionChipIds') ?? $request->request->all('expansionChipIds');
        $chipArray = null;
        if ($chipIds) {
            if (is_array($chipIds)) {
                $chipArray = $chipIds;
            } else {
                $chipArray = json_decode($chipIds);
            }
            $criterias['expansionChips'] = $chipArray;
        }
        $manufacturerId = htmlentities($request->query->get('manufacturerId') ?? '');
        if ($manufacturerId && intval($manufacturerId)) {
            $criterias['manufacturer'] = "$manufacturerId";
        } elseif ($manufacturerId === "NULL") {
            $criterias['manufacturer'] = null;
        }
        $typeId = htmlentities($request->query->get('typeId') ?? '');
        if ($typeId && intval($typeId)) {
            $criterias['type'] = "$typeId";
        } elseif ($typeId === "NULL") {
            $criterias['type'] = null;
        }
        return $criterias;
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
        if ($form['type']->getData()) {
            if ($form['type']->getData()->getId() == 0) {
                $parameters['typeId']  = "NULL";
            } else {
                $parameters['typeId'] = $form['type']->getData()->getId();
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

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['showImages'] = $form['searchWithImages']->getData();
        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }
    private function _searchFormHandlerExpansionCard(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        ExpansionCardTypeRepository $expansionCardTypeRepository,
    ): FormInterface {
        $expansionCardManufacturers = $manufacturerRepository->findAllExpansionCardManufacturer();
        $expansionCardTypes = $expansionCardTypeRepository->findAll();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($expansionCardManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'expansionCardManufacturers' => $expansionCardManufacturers,
            'expansionCardTypes' => $expansionCardTypes,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
