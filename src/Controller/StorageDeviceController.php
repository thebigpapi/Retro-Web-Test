<?php

namespace App\Controller;

use App\Entity\Chipset;
use App\Entity\Manufacturer;
use App\Form\Chipset\Search;
use App\Repository\CdDriveRepository;
use App\Repository\ChipsetRepository;
use App\Repository\FloppyDriveRepository;
use App\Repository\HardDriveRepository;
use App\Repository\ManufacturerRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class StorageDeviceController extends AbstractController
{
    #[Route(path: '/harddrive/{id}', name: 'hard_drive_show', requirements: ['id' => '\d+'])]
    public function hardDriveShow(int $id, HardDriveRepository $hardDriveRepository)
    {
        $hdd = $hardDriveRepository->find($id);
        if (!$hdd) {
            throw $this->createNotFoundException(
                'No hard drive found for id ' . $id
            );
        } else {
            return $this->render('harddrive/show.html.twig', [
                'harddrive' => $hdd,
                'controller_name' => 'StorageDeviceController',
            ]);
        }
    }
    #[Route(path: '/cddrive/{id}', name: 'cd_drive_show', requirements: ['id' => '\d+'])]
    public function cdDriveShow(int $id, CdDriveRepository $cdDriveRepository)
    {
        $cdd = $cdDriveRepository->find($id);
        if (!$cdd) {
            throw $this->createNotFoundException(
                'No cd drive found for id ' . $id
            );
        } else {
            return $this->render('cddrive/show.html.twig', [
                'cddrive' => $cdd,
                'controller_name' => 'StorageDeviceController',
            ]);
        }
    }
    #[Route(path: '/floppydrive/{id}', name: 'floppy_drive_show', requirements: ['id' => '\d+'])]
    public function floppyDriveShow(int $id, FloppyDriveRepository $floppyDriveRepository)
    {
        $fdd = $floppyDriveRepository->find($id);
        if (!$fdd) {
            throw $this->createNotFoundException(
                'No floppy drive found for id ' . $id
            );
        } else {
            return $this->render('floppydrive/show.html.twig', [
                'floppydrive' => $fdd,
                'controller_name' => 'StorageDeviceController',
            ]);
        }
    }
    /*public function getCriteria(Request $request){
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
        return $criterias;
    }


    #[Route(path: '/chipsets/', name: 'chipsetsearch', methods: ['GET'])]
    public function searchResult(Request $request, PaginatorInterface $paginator, ChipsetRepository $chipsetRepository, ManufacturerRepository $manufacturerRepository)
    {
        $form = $this->_searchFormHandler($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('chipsetsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteria($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if ($criterias == array()) {
            return $this->render('chipset/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        else{
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
                'show_images' => $showImages,
            ]);
        }


    }
    #[Route('/chipsets/results', name: 'chipsetlivesearch')]
    public function liveResults(
        Request $request,
        PaginatorInterface $paginator,
        ChipsetRepository $chipsetRepository
    ): Response {
        $criterias = $this->getCriteria($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        
        $data = $chipsetRepository->findByChipset($criterias);
        
        $chipsets = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
            //dd($chipsets);
        $string = "/chipsets/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('chipset/result.html.twig', [
            'controller_name' => 'MotherboardController',
            'chipsets' => $chipsets,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }

    #[Route('/chipsets/live', name: 'chipsetlivewrapper')]
    public function liveSearch(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
    ): Response {
        $form = $this->_searchFormHandler($request, $manufacturerRepository);

        return $this->redirect($this->generateUrl('chipsetlivesearch', $this->searchFormToParam($request, $form)));
    }

    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();

        $parameters['showImages'] = $form['searchWithImages']->getData();
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        if ($form['chipsetManufacturer']->getData()) {
            if ($form['chipsetManufacturer']->getData()->getId() == 0) {
                $parameters['chipsetManufacturerId']  = "NULL";
            } else {
                $parameters['chipsetManufacturerId'] = $form['chipsetManufacturer']->getData()->getId();
            }
        }
        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }


    #[Route(path: '/chipsets/index/{letter}', name: 'chipsetindex', requirements: ['letter' => '\w'])]
    public function index(PaginatorInterface $paginator, string $letter, ChipsetRepository $chipsetRepository, Request $request)
    {
        $data = $chipsetRepository->findAllAlphabetic($letter);
        $chipsets = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );
        return $this->render('chipset/index.html.twig', [
            'chipsets' => $chipsets,
            'chipset_count' => count($data),
            'letter' => $letter,
        ]);
    }
    private function _searchFormHandler(
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
    }*/
}
