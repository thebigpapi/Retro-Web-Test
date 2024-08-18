<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\Chip\Search;
use App\Repository\ChipRepository;
use App\Repository\ExpansionChipTypeRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

class ChipController extends AbstractController
{
    #[Route('/chips/{id}', name: 'chip_show', requirements: ['id' => '\d+'])]
    public function show(int $id, ChipRepository $chipRepository): Response
    {
        $chip = $chipRepository->find($id);
        if (!$chip) {
            throw $this->createNotFoundException(
                'No chip found for id ' . $id
            );
        } else {
            return $this->render('chip/show.html.twig', [
                'chip' => $chip,
                'controller_name' => 'ChipController',
            ]);
        }

    }
    #[Route(path: '/chips/', name: 'chipsearch', methods: ['GET'])]
    public function searchResultChip(Request $request, PaginatorInterface $paginator, ChipRepository $chipRepository, ManufacturerRepository $manufacturerRepository, ExpansionChipTypeRepository $chipTypeRepository)
    {
        $latestChips = $chipRepository->findLatest(8);
        $form = $this->_searchFormHandlerChip($request, $manufacturerRepository, $chipTypeRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('chipsearch', $this->searchFormToParamChip($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaChip($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('chip/search.html.twig', [
                'form' => $form->createView(),
                'latestChips' => $latestChips,
            ]);
        }
        $data = $chipRepository->findByChip($criterias);
        //dd($data);
        $chips = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('chip/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ChipController',
            'chips' => $chips,
            'show_images' => $showImages,
        ]);

    }

    #[Route('/chips/live', name: 'chiplivewrapper')]
    public function liveSearchChip(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        ExpansionChipTypeRepository $chipTypeRepository
    ): Response {
        $form = $this->_searchFormHandlerChip($request, $manufacturerRepository, $chipTypeRepository);

        return $this->redirect($this->generateUrl('chiplivesearch', $this->searchFormToParamChip($request, $form)));
    }

    #[Route('/chips/results', name: 'chiplivesearch')]
    public function liveResultsChip(
        Request $request,
        PaginatorInterface $paginator,
        ChipRepository $chipRepository
    ): Response {
        $criterias = $this->getCriteriaChip($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $chipRepository->findByChip($criterias);
        $chips = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/chips/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('chip/result.html.twig', [
            'controller_name' => 'ChipController',
            'chips' => $chips,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaChip(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $devId = htmlentities($request->query->get('deviceId') ?? '');
        if ($devId) {
            $criterias['deviceId'] = "$devId";
        }
        $chipId = htmlentities($request->query->get('chipId') ?? '');
        if ($chipId && intval($chipId)) {
            $criterias['expansionchip'] = "$chipId";
        } elseif ($chipId === "NULL") {
            $criterias['expansionchip'] = null;
        }
        $chipManufacturerId = htmlentities($request->query->get('chipManufacturerId') ?? '');
        if ($chipManufacturerId && intval($chipManufacturerId)) {
            $criterias['manufacturer'] = "$chipManufacturerId";
        } elseif ($chipManufacturerId === "NULL") {
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
    private function searchFormToParamChip(Request $request, $form): array
    {
        $parameters = array();
        if ($form['chipManufacturer']->getData()) {
            if ($form['chipManufacturer']->getData()->getId() == 0) {
                $parameters['chipManufacturerId']  = "NULL";
            } else {
                $parameters['chipManufacturerId'] = $form['chipManufacturer']->getData()->getId();
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
    private function _searchFormHandlerChip(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        ExpansionChipTypeRepository $chipTypeRepository,
    ): FormInterface {
        $chipManufacturers = $manufacturerRepository->findAllChipManufacturer();
        $chipTypes = $chipTypeRepository->findAll();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($chipManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'chipManufacturers' => $chipManufacturers,
            'chipTypes' => $chipTypes,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
