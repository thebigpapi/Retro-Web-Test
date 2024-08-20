<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\Chipset\Search;
use App\Repository\ChipsetRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

class ChipsetController extends AbstractController
{
    #[Route(path: '/chipsets/{id}', name: 'chipset_show', requirements: ['id' => '\d+'])]
    public function showChipset(int $id, ChipsetRepository $chipsetRepository)
    {
        $chipset = $chipsetRepository->find($id);
        if (!$chipset) {
            throw $this->createNotFoundException(
                'No chipset found for id ' . $id
            );
        } else {
            return $this->render('chipset/show.html.twig', [
                'chipset' => $chipset,
                'controller_name' => 'ChipsetController',
            ]);
        }
    }

    #[Route(path: '/chipsets/', name: 'chipsetsearch', methods: ['GET'])]
    public function searchResultChipset(Request $request, PaginatorInterface $paginator, ChipsetRepository $chipsetRepository, ManufacturerRepository $manufacturerRepository)
    {
        $latestChipsets = $chipsetRepository->findLatest(8);
        $form = $this->_searchFormHandlerChipset($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('chipsetsearch', $this->searchFormToParamChipset($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaChipset($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('chipset/search.html.twig', [
                'form' => $form->createView(),
                'latestChipsets' => $latestChipsets,
            ]);
        }

        $data = $chipsetRepository->findByChipset($criterias);
        $chipsets = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('chipset/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ChipsetController',
            'chipsets' => $chipsets,
        ]);
    }

    #[Route('/chipsets/live', name: 'chipsetlivewrapper')]
    public function liveSearchChipset(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
    ): Response {
        $form = $this->_searchFormHandlerChipset($request, $manufacturerRepository);

        return $this->redirect($this->generateUrl('chipsetlivesearch', $this->searchFormToParamChipset($request, $form)));
    }

    #[Route('/chipsets/results', name: 'chipsetlivesearch')]
    public function liveResultsChipset(
        Request $request,
        PaginatorInterface $paginator,
        ChipsetRepository $chipsetRepository
    ): Response {
        $criterias = $this->getCriteriaChipset($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $chipsetRepository->findByChipset($criterias);
        $chipsets = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/chipsets/?";
        foreach ($request->query as $key => $value){
            if($key == "chipIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else{
                if($key != "domTarget")
                    $string .= $key . '=' . $value . '&';
            }
        }
        return $this->render('chipset/result.html.twig', [
            'controller_name' => 'ChipsetController',
            'chipsets' => $chipsets,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaChipset(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $chipsetId = htmlentities($request->query->get('chipsetId') ?? '');
        if ($chipsetId && intval($chipsetId)) {
            $criterias['chipset'] = "$chipsetId";
        } elseif ($chipsetId === "NULL") {
            $criterias['chipset'] = null;
        }
        $chipsetManufacturerId = htmlentities($request->query->get('chipsetManufacturerId') ?? '');
        if (
            $chipsetManufacturerId
            &&
            intval($chipsetManufacturerId)
            &&
            !array_key_exists('chipset', $criterias)
        ) {
            $criterias['manufacturer'] = "$chipsetManufacturerId";
        } elseif ($chipsetManufacturerId === "NULL" && !array_key_exists('chipset', $criterias)) {
            $criterias['manufacturer'] = null;
        }
        $chipIds = $request->query->all('chipIds') ?? $request->request->all('chipIds');
        $chipArray = null;
        if ($chipIds) {
            if (is_array($chipIds)) {
                $chipArray = $chipIds;
            } else {
                $chipArray = json_decode($chipIds);
            }
            $criterias['chips'] = $chipArray;
        }
        return $criterias;
    }
    private function searchFormToParamChipset(Request $request, $form): array
    {
        $parameters = array();
        if ($form['chipsetManufacturer']->getData()) {
            if ($form['chipsetManufacturer']->getData()->getId() == 0) {
                $parameters['chipsetManufacturerId']  = "NULL";
            } else {
                $parameters['chipsetManufacturerId'] = $form['chipsetManufacturer']->getData()->getId();
            }
        }

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['name'] = $form['name']->getData();

        $chips = $form['chips']->getData();
        if ($chips) {
            $parameters['chipIds'] = array();
            $loopCount = 0;
            foreach ($chips as $chip) {
                if($loopCount >= 6)
                    break;
                if($chip != null)
                    array_push($parameters['chipIds'], $chip->getId());
            }
        }

        return $parameters;
    }
    private function _searchFormHandlerChipset(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
    ): FormInterface {
        $notIdentifiedMessage = "Not identified";
        $chipsetManufacturers = $manufacturerRepository->findAllChipsetManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($chipsetManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'chipsetManufacturers' => $chipsetManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
