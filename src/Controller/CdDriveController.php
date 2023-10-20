<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\CdDrive\Search;
use App\Repository\CdDriveRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class CdDriveController extends AbstractController
{
    #[Route(path: '/cddrives/{id}', name: 'cd_drive_show', requirements: ['id' => '\d+'])]
    public function cdDriveShow(int $id, CdDriveRepository $cdDriveRepository)
    {
        $cdd = $cdDriveRepository->find($id);
        if (!$cdd) {
            throw $this->createNotFoundException(
                'No optical drive found for id ' . $id
            );
        } else {
            return $this->render('cddrive/show.html.twig', [
                'cddrive' => $cdd,
                'controller_name' => 'CdDriveController',
            ]);
        }
    }
    #[Route(path: '/cddrives/', name: 'cddsearch', methods: ['GET'])]
    public function searchResultCdd(Request $request, PaginatorInterface $paginator, CdDriveRepository $cddRepository, ManufacturerRepository $manufacturerRepository)
    {
        $form = $this->_searchFormHandlerCdd($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('cddsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaCdd($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if ($criterias == array()) {
            return $this->render('cddrive/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        else{
            $data = $cddRepository->findByCdd($criterias);
            $cdds = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
            return $this->render('cddrive/search.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'CdDriveController',
                'cdds' => $cdds,
                'show_images' => $showImages,
            ]);
        }
    }
    #[Route('/cddrives/live', name: 'cddlivewrapper')]
    public function liveSearchCdd(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerCdd($request, $manufacturerRepository);
        return $this->redirect($this->generateUrl('cddlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/cddrives/results', name: 'cddlivesearch')]
    public function liveResultsCdd(Request $request, PaginatorInterface $paginator, CdDriveRepository $cddRepository): Response
    {
        $criterias = $this->getCriteriaCdd($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $cddRepository->findByCdd($criterias);
        $cdds = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/cddrives/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('cddrive/result.html.twig', [
            'controller_name' => 'CdDriveController',
            'cdds' => $cdds,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaCdd(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $cddManufacturerId = htmlentities($request->query->get('cddManufacturerId') ?? '');
        if ($cddManufacturerId && intval($cddManufacturerId)) {
            $criterias['manufacturer'] = "$cddManufacturerId";
        } elseif ($cddManufacturerId === "NULL") {
            $criterias['manufacturer'] = null;
        }
        return $criterias;
    }
    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();
        if ($form['cddManufacturer']->getData()) {
            if ($form['cddManufacturer']->getData()->getId() == 0) {
                $parameters['cddManufacturerId']  = "NULL";
            } else {
                $parameters['cddManufacturerId'] = $form['cddManufacturer']->getData()->getId();
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
    private function _searchFormHandlerCdd(Request $request, ManufacturerRepository $manufacturerRepository,): FormInterface
    {
        $cddManufacturers = $manufacturerRepository->findAllCddManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($cddManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'cddManufacturers' => $cddManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
