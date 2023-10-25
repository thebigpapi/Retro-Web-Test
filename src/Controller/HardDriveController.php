<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\HardDrive\Search;
use App\Repository\HardDriveRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class HardDriveController extends AbstractController
{
    #[Route(path: '/harddrives/{id}', name: 'hard_drive_show', requirements: ['id' => '\d+'])]
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
                'controller_name' => 'HardDriveController',
            ]);
        }
    }
    #[Route(path: '/harddrives/', name: 'hddsearch', methods: ['GET'])]
    public function searchResultHdd(Request $request, PaginatorInterface $paginator, HardDriveRepository $hddRepository, ManufacturerRepository $manufacturerRepository)
    {
        $form = $this->_searchFormHandlerHdd($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('hddsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaHdd($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('harddrive/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $data = $hddRepository->findByHdd($criterias);
        $hdds = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('harddrive/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'HardDriveController',
            'hdds' => $hdds,
            'show_images' => $showImages,
        ]);
    }
    #[Route('/harddrives/live', name: 'hddlivewrapper')]
    public function liveSearchHdd(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerHdd($request, $manufacturerRepository);
        return $this->redirect($this->generateUrl('hddlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/harddrives/results', name: 'hddlivesearch')]
    public function liveResultsHdd(Request $request, PaginatorInterface $paginator, HardDriveRepository $hddRepository): Response
    {
        $criterias = $this->getCriteriaHdd($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $hddRepository->findByHdd($criterias);
        $hdds = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/harddrives/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('harddrive/result.html.twig', [
            'controller_name' => 'HardDriveController',
            'hdds' => $hdds,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaHdd(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $capacity = htmlentities($request->query->get('capacity') ?? '');
        if ($capacity) {
            $criterias['capacity'] = "$capacity";
        }
        $hddManufacturerId = htmlentities($request->query->get('hddManufacturerId') ?? '');
        if ($hddManufacturerId && intval($hddManufacturerId)) {
            $criterias['manufacturer'] = "$hddManufacturerId";
        } elseif ($hddManufacturerId === "NULL") {
            $criterias['manufacturer'] = null;
        }
        return $criterias;
    }
    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();
        if ($form['hddManufacturer']->getData()) {
            if ($form['hddManufacturer']->getData()->getId() == 0) {
                $parameters['hddManufacturerId']  = "NULL";
            } else {
                $parameters['hddManufacturerId'] = $form['hddManufacturer']->getData()->getId();
            }
        }

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['showImages'] = $form['searchWithImages']->getData();
        $parameters['name'] = $form['name']->getData();
        $parameters['capacity'] = $form['capacity']->getData();

        return $parameters;
    }
    private function _searchFormHandlerHdd(Request $request, ManufacturerRepository $manufacturerRepository,): FormInterface
    {
        $hddManufacturers = $manufacturerRepository->findAllHddManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($hddManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'hddManufacturers' => $hddManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
