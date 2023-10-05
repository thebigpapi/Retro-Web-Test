<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\FloppyDrive\Search;
use App\Repository\FloppyDriveRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class FloppyDriveController extends AbstractController
{
    #[Route(path: '/floppydrives/{id}', name: 'floppy_drive_show', requirements: ['id' => '\d+'])]
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
                'controller_name' => 'FloppyDriveController',
            ]);
        }
    }
    #[Route(path: '/floppydrives/', name: 'fddsearch', methods: ['GET'])]
    public function searchResultFdd(Request $request, PaginatorInterface $paginator, FloppyDriveRepository $fddRepository, ManufacturerRepository $manufacturerRepository)
    {
        $form = $this->_searchFormHandlerFdd($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('fddsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaFdd($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if ($criterias == array()) {
            return $this->render('floppydrive/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        else{
            $data = $fddRepository->findByFdd($criterias);
            $fdds = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
            return $this->render('floppydrive/search.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'FloppyDriveController',
                'fdds' => $fdds,
                'show_images' => $showImages,
            ]);
        }
    }
    #[Route('/floppydrives/live', name: 'fddlivewrapper')]
    public function liveSearchFdd(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerFdd($request, $manufacturerRepository);
        return $this->redirect($this->generateUrl('fddlivesearch', $this->searchFormToParam($request, $form)));
    }

    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();

        $parameters['showImages'] = $form['searchWithImages']->getData();
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        if ($form['fddManufacturer']->getData()) {
            if ($form['fddManufacturer']->getData()->getId() == 0) {
                $parameters['fddManufacturerId']  = "NULL";
            } else {
                $parameters['fddManufacturerId'] = $form['fddManufacturer']->getData()->getId();
            }
        }
        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }
    #[Route('/floppyrives/results', name: 'fddlivesearch')]
    public function liveResultsFdd(Request $request, PaginatorInterface $paginator, FloppyDriveRepository $fddRepository): Response
    {
        $criterias = $this->getCriteriaFdd($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $fddRepository->findByFdd($criterias);
        $fdds = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/floppydrives/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('floppydrive/result.html.twig', [
            'controller_name' => 'FloppyDriveController',
            'fdds' => $fdds,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaFdd(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $fddManufacturerId = htmlentities($request->query->get('fddManufacturerId') ?? '');
        if ($fddManufacturerId && intval($fddManufacturerId)) {
            $criterias['manufacturer'] = "$fddManufacturerId";
        } elseif ($fddManufacturerId === "NULL") {
            $criterias['manufacturer'] = null;
        }
        return $criterias;
    }
    private function _searchFormHandlerFdd(Request $request, ManufacturerRepository $manufacturerRepository,): FormInterface
    {
        $fddManufacturers = $manufacturerRepository->findAllFddManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($fddManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'fddManufacturers' => $fddManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
