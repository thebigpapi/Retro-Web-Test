<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\ExpansionChip\Search;
use App\Repository\ExpansionChipRepository;
use App\Repository\ExpansionChipTypeRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ExpansionChipController extends AbstractController
{
    #[Route('/expansion-chips/{id}', name: 'expansion_chip_show', requirements: ['id' => '\d+'])]
    public function show(int $id, ExpansionChipRepository $expansionChipRepository): Response
    {
        $expansionChip = $expansionChipRepository->find($id);
        if (!$expansionChip) {
            throw $this->createNotFoundException(
                'No expansion chip found for id ' . $id
            );
        } else {
            return $this->render('expansion_chip/show.html.twig', [
                'expansion_chip' => $expansionChip,
                'controller_name' => 'ExpansionChipController',
            ]);
        }

    }
    #[Route(path: '/expansion-chips/', name: 'expansionchipsearch', methods: ['GET'])]
    public function searchResultExpansionChip(Request $request, PaginatorInterface $paginator, ExpansionChipRepository $expansionChipRepository, ManufacturerRepository $manufacturerRepository, ExpansionChipTypeRepository $expansionChipTypeRepository)
    {
        $form = $this->_searchFormHandlerExpansionChip($request, $manufacturerRepository, $expansionChipTypeRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('expansionchipsearch', $this->searchFormToParamExpansionChip($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaExpansionChip($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('expansion_chip/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $data = $expansionChipRepository->findByExpansionChip($criterias);
        $expansionChips = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('expansion_chip/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ExpansionChipController',
            'expansionchips' => $expansionChips,
            'show_images' => $showImages,
        ]);

    }

    #[Route('/expansion-chips/live', name: 'expansionchiplivewrapper')]
    public function liveSearchExpansionChip(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        ExpansionChipTypeRepository $expansionChipTypeRepository
    ): Response {
        $form = $this->_searchFormHandlerExpansionChip($request, $manufacturerRepository, $expansionChipTypeRepository);

        return $this->redirect($this->generateUrl('expansionchiplivesearch', $this->searchFormToParamExpansionChip($request, $form)));
    }

    #[Route('/expansion-chips/results', name: 'expansionchiplivesearch')]
    public function liveResultsExpansionChip(
        Request $request,
        PaginatorInterface $paginator,
        ExpansionChipRepository $expansionChipRepository
    ): Response {
        $criterias = $this->getCriteriaExpansionChip($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $expansionChipRepository->findByExpansionChip($criterias);
        $expansionChips = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/expansion-chips/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('expansion_chip/result.html.twig', [
            'controller_name' => 'ExpansionChipController',
            'expansionchips' => $expansionChips,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaExpansionChip(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $devId = htmlentities($request->query->get('deviceId') ?? '');
        if ($devId) {
            $criterias['deviceId'] = "$devId";
        }
        $expansionChipId = htmlentities($request->query->get('expansionChipId') ?? '');
        if ($expansionChipId && intval($expansionChipId)) {
            $criterias['expansionchip'] = "$expansionChipId";
        } elseif ($expansionChipId === "NULL") {
            $criterias['expansionchip'] = null;
        }
        $expansionChipManufacturerId = htmlentities($request->query->get('expansionChipManufacturerId') ?? '');
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
    private function searchFormToParamExpansionChip(Request $request, $form): array
    {
        $parameters = array();
        if ($form['expansionChipManufacturer']->getData()) {
            if ($form['expansionChipManufacturer']->getData()->getId() == 0) {
                $parameters['expansionChipManufacturerId']  = "NULL";
            } else {
                $parameters['expansionChipManufacturerId'] = $form['expansionChipManufacturer']->getData()->getId();
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
        $parameters['deviceId'] = $form['deviceId']->getData();

        return $parameters;
    }
    private function _searchFormHandlerExpansionChip(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        ExpansionChipTypeRepository $expansionChipTypeRepository,
    ): FormInterface {
        $expansionChipManufacturers = $manufacturerRepository->findAllExpansionChipManufacturer();
        $expansionChipTypes = $expansionChipTypeRepository->findAll();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($expansionChipManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'expansionChipManufacturers' => $expansionChipManufacturers,
            'expansionChipTypes' => $expansionChipTypes,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
