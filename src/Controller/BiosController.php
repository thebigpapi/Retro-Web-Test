<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Manufacturer;
use App\Form\Bios\Search;
use App\Repository\ManufacturerRepository;
use App\Repository\ExpansionChipRepository;
use App\Repository\MotherboardBiosRepository;

class BiosController extends AbstractController
{
    #[Route(path: '/bios/', name: 'biossearch', methods: ['GET', 'POST'])]
    public function searchResultBios(Request $request, PaginatorInterface $paginator, ExpansionChipRepository $expansionChipRepository, MotherboardBiosRepository $motherboardBiosRepository, ManufacturerRepository $manufacturerRepository)
    {
        $form = $this->_searchFormHandlerBios($request, $expansionChipRepository, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('biossearch', $this->searchFormToParamBios($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaBios($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('bios/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $data = $motherboardBiosRepository->findBios($criterias);
        $bios = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('bios/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'BiosController',
            'bios' => $bios,
        ]);
    }

    #[Route('/bios/live', name: 'bioslivewrapper')]
    public function liveSearchBios(Request $request, ExpansionChipRepository $expansionChipRepository, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerBios($request, $expansionChipRepository, $manufacturerRepository);

        return $this->redirect($this->generateUrl('bioslivesearch', $this->searchFormToParamBios($request, $form)));
    }

    #[Route('/bios/results', name: 'bioslivesearch')]
    public function liveResultsBios(Request $request, PaginatorInterface $paginator, MotherboardBiosRepository $motherboardBiosRepository): Response
    {
        $criterias = $this->getCriteriaBios($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $motherboardBiosRepository->findBios($criterias);
        $bios = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/bios/?";
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
        return $this->render('bios/result.html.twig', [
            'controller_name' => 'BiosController',
            'bios' => $bios,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaBios(Request $request){
        $criterias = array();
        $postString = $request->query->get('postString');
        if ($postString) {
            $criterias['post_string'] = "$postString";
        }
        $coreVersion = htmlentities($request->query->get('coreVersion') ?? '');
        if ($coreVersion) {
            $criterias['core_version'] = "$coreVersion";
        }
        $biosManufacturerId = htmlentities($request->query->get('biosManufacturerId') ?? '');
        if ($biosManufacturerId && intval($biosManufacturerId)) {
            $criterias['manufacturer_id'] = intval($biosManufacturerId);
        } elseif ($biosManufacturerId == "NULL") {
            $criterias['manufacturer_id'] = null;
        }
        $moboManufacturerId = htmlentities($request->query->get('moboManufacturerId') ?? '');
        if ($moboManufacturerId && intval($moboManufacturerId)) {
            $criterias['mbmanufacturer_id'] = intval($moboManufacturerId);
        } elseif ($moboManufacturerId == "NULL") {
            $criterias['mbmanufacturer_id'] = null;
        }
        $filePresent = htmlentities($request->query->get('filePresent') ?? '');
        if ($filePresent && boolval($filePresent)) {
            $criterias['file_present'] = boolval($filePresent);
        }
        $chipsetId = htmlentities($request->query->get('chipsetId') ?? '');
        if ($chipsetId && intval($chipsetId)) {
            $criterias['chipset_id'] = intval($chipsetId);
        } elseif ($chipsetId == "NULL") {
            $criterias['chipset_id'] = null;
        }
        $chipIds = $request->query->get('expansionChipIds') ?? $request->request->get('expansionChipIds');
        $chipArray = null;
        if ($chipIds) {
            if (is_array($chipIds)) {
                $chipArray = $chipIds;
            } else {
                $chipArray = json_decode($chipIds);
            }
            $criterias['expansionChips'] = $chipArray;
        }
        return $criterias;
    }
    private function searchFormToParamBios(Request $request, $form): array
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

        if ($postString = $form['post_string']->getData()) {
            $parameters['postString'] = $postString;
        }
        if ($coreVersion = $form['core_version']->getData()) {
            $parameters['coreVersion'] = $coreVersion;
        }
        if ($biosManufacturer = $form['manufacturer']->getData()) {
            $parameters['biosManufacturerId'] = $biosManufacturer->getId();
        }
        if ($moboManufacturer = $form['moboManufacturer']->getData()) {
            $parameters['moboManufacturerId'] = $moboManufacturer->getId();
        }
        $expchips = $form['expansionChips']->getData();
        if ($expchips) {
            $parameters['expansionChipIds'] = array();
            foreach ($expchips as $chip) {
                if($chip != null)
                    array_push($parameters['expansionChipIds'], $chip->getId());
            }
        }
        if ($filePresent = $form['file_present']->getData()) {
            $parameters['filePresent'] = $filePresent;
        }
        if ($chipset = $form['chipset']->getData()) {
            $parameters['chipsetId'] = $chipset->getId();
        }

        return $parameters;
    }
    private function _searchFormHandlerBios(Request $request, ExpansionChipRepository $expansionChipRepository, ManufacturerRepository $manufacturerRepository): FormInterface
    {
        $chipsetManufacturers = $manufacturerRepository->findAllChipsetManufacturer();
        $biosManufacturers = $manufacturerRepository->findAllBiosManufacturer();
        $moboManufacturers = $manufacturerRepository->findAllMotherboardManufacturer();
        $expansionChip = $expansionChipRepository->findAll();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        $form = $this->createForm(Search::class, array(), [
            'biosManufacturers' => $biosManufacturers,
            'moboManufacturers' => $moboManufacturers,
            'expansionChips' => $expansionChip,
            'chipsetManufacturers' => $chipsetManufacturers
        ]);

        $form->handleRequest($request);

        return $form;
    }

    #[Route(path: '/bios/list', name: 'bios_list')]
    public function biosList(ManufacturerRepository $manufacturerRepository)
    {
        $biosCodes = $manufacturerRepository->findAllBiosManufacturerAdv();
        $chipdata = $manufacturerRepository->findAllChipsetBiosManufacturer();
        return $this->render('bios/list.html.twig', [
            'controller_name' => 'MainController',
            'biosCodes' => $biosCodes,
            'chipCodes' => $chipdata,
        ]);
    }
}
