<?php

namespace App\Controller;

use App\Entity\Processor;
use App\Entity\Manufacturer;
use App\Form\Processor\Search;
use App\Repository\ProcessorRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ProcessorController extends AbstractController
{
    #[Route('/cpus/{id}', name:'processor_show', requirements:['id' => '\d+'])]
    public function showCpu(int $id, ProcessorRepository $cpuRepository): Response
    {
        $cpu = $cpuRepository->find($id);
        if (!$cpu) {
            throw $this->createNotFoundException(
                'No $cpu found for id ' . $id
            );
        } else {
            return $this->render('cpu/show.html.twig', [
                'cpu' => $cpu,
                'controller_name' => 'ProcessorController',
            ]);
        }
    }

    #[Route('/cpus/', name:'cpusearch', methods: ['GET', 'POST'])]
    public function searchResultCpu(Request $request, PaginatorInterface $paginator, ManufacturerRepository $manufacturerRepository, ProcessorRepository $cpuRepository): Response
    {
        $form = $this->_searchFormHandlerCpu($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('chipsetsearch', $this->searchFormToParamCpu($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaCpu($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if ($criterias == array()) {
            return $this->render('cpu/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        else{
            $data = $cpuRepository->findByCPU($criterias);
            $cpus = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
            return $this->render('cpu/search.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'ProcessorController',
                'show_images' => $showImages,
                'cpus' => $cpus,
            ]);
        }
    }
    #[Route('/cpus/live', name: 'cpulivewrapper')]
    public function liveSearchCpu(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerCpu($request, $manufacturerRepository);
        return $this->redirect($this->generateUrl('cpulivesearch', $this->searchFormToParamCpu($request, $form)));
    }

    #[Route('/cpus/results', name: 'cpulivesearch')]
    public function liveResultsCpu(Request $request, PaginatorInterface $paginator, ProcessorRepository $cpuRepository): Response
    {
        $criterias = $this->getCriteriaCpu($request);
        $showImages = boolval(htmlentities($request->query->get('showImages')));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $cpuRepository->findByCPU($criterias);
            $cpus = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/cpus/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('cpu/result.html.twig', [
            'controller_name' => 'ProcessorController',
            'cpus' => $cpus,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaCpu(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $cpuManufacturerId = htmlentities($request->query->get('cpuManufacturerId') ?? '');
        if ($cpuManufacturerId && intval($cpuManufacturerId) && !array_key_exists('cpu', $criterias)) {
            $criterias['manufacturer'] = "$cpuManufacturerId";
        } elseif ($cpuManufacturerId === "NULL" && !array_key_exists('cpu', $criterias)) {
            $criterias['manufacturer'] = null;
        }
        return $criterias;
    }
    private function searchFormToParamCpu(Request $request, $form): array
    {
        $parameters = array();
        if ($form['cpuManufacturer']->getData()) {
            if ($form['cpuManufacturer']->getData()->getId() == 0) {
                $parameters['cpuManufacturerId']  = "NULL";
            } else {
                $parameters['cpuManufacturerId'] = $form['cpuManufacturer']->getData()->getId();
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
    private function _searchFormHandlerCpu(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
    ): FormInterface {
        $cpuManufacturers = $manufacturerRepository->findAllProcessorManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($cpuManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'cpuManufacturers' => $cpuManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }

    #[Route('/cpus/index/{letter}', name:'processorindex', requirements:['letter' => '\w|[?]'], methods:["GET"])]
    public function indexCpu(Request $request, PaginatorInterface $paginator, string $letter, ProcessorRepository $cpuRepository): Response
    {
        if ($letter === "?") {
            $letter = "";
        }
        $data = $cpuRepository->findAllAlphabetic($letter);

        usort(
            $data,
            function (Processor $a, Processor $b) {
                return strcmp($a->getName(), $b->getName());
            }
        );

        $cpus = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('cpu/index.html.twig', [
            'cpus' => $cpus,
            'cpu_count' => count($data),
            'letter' => $letter,
        ]);
    }
}
