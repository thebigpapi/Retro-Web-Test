<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\ExpansionCard\Search;
use App\Repository\ExpansionCardRepository;
use App\Repository\ExpansionCardTypeRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

class ExpansionCardController extends AbstractController
{
    #[Route('/expansioncards/{id}', name: 'expansioncard_show', requirements: ['id' => '\d+'])]
    public function show(int $id, ExpansionCardRepository $expansionCardRepository): Response
    {
        $expansionCard = $expansionCardRepository->find($id);
        if (!$expansionCard) {
            throw $this->createNotFoundException(
                'No expansion card found for id ' . $id
            );
        } else {
            return $this->render('expansioncard/show.html.twig', [
                'expansioncard' => $expansionCard,
                'controller_name' => 'ExpansionCardController',
            ]);
        }

    }
    #[Route(path: '/expansioncards/', name: 'expansioncardsearch', methods: ['GET'])]
    public function searchResultExpansionCard(Request $request, PaginatorInterface $paginator, ExpansionCardRepository $expansionCardRepository, ManufacturerRepository $manufacturerRepository, ExpansionCardTypeRepository $expansionCardTypeRepository)
    {
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
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
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
        $expansionChipId = htmlentities($request->query->get('expansionChipId') ?? '');
        if ($expansionChipId && intval($expansionChipId)) {
            $criterias['expansionchip'] = "$expansionChipId";
        } elseif ($expansionChipId === "NULL") {
            $criterias['expansionchip'] = null;
        }
        $expansionChipManufacturerId = htmlentities($request->query->get('manufacturerId') ?? '');
        if ($expansionChipManufacturerId && intval($expansionChipManufacturerId)) {
            $criterias['manufacturer'] = "$expansionChipManufacturerId";
        } elseif ($expansionChipManufacturerId === "NULL") {
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
