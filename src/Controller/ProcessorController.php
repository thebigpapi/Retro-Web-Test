<?php

namespace App\Controller;

use App\Entity\CpuSocket;
use App\Entity\Manufacturer;
use App\Form\Processor\Search;
use App\Repository\CpuSpeedRepository;
use App\Repository\ProcessorRepository;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
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
    public function searchResultCpu(Request $request, PaginatorInterface $paginator, ManufacturerRepository $manufacturerRepository, ProcessorRepository $cpuRepository, CpuSpeedRepository $cpuSpeedRepository): Response
    {
        $form = $this->_searchFormHandlerCpu($request, $manufacturerRepository, $cpuSpeedRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('chipsetsearch', $this->searchFormToParamCpu($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaCpu($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('cpu/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }

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
    #[Route('/cpus/live', name: 'cpulivewrapper')]
    public function liveSearchCpu(Request $request, ManufacturerRepository $manufacturerRepository, CpuSpeedRepository $cpuSpeedRepository): Response
    {
        $form = $this->_searchFormHandlerCpu($request, $manufacturerRepository, $cpuSpeedRepository);
        return $this->redirect($this->generateUrl('cpulivesearch', $this->searchFormToParamCpu($request, $form)));
    }

    #[Route('/cpus/results', name: 'cpulivesearch')]
    public function liveResultsCpu(Request $request, PaginatorInterface $paginator, ProcessorRepository $cpuRepository): Response
    {
        $criterias = $this->getCriteriaCpu($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $cpuRepository->findByCPU($criterias);
            $cpus = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/cpus/?";
        foreach ($request->query as $key => $value){
            if($key == "socketIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else if($key == "platformIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else{
                if($key != "domTarget")
                    $string .= $key . '=' . $value . '&';
            }
        }
        return $this->render('cpu/result.html.twig', [
            'controller_name' => 'ProcessorController',
            'cpus' => $cpus,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function addCriteriaById(Request $request, array &$criterias, string $htmlId, string $sqlId): void
    {
        $entityId = htmlentities($request->query->get($htmlId) ?? ($request->request->get($htmlId) ?? ''));
        if ($entityId && intval($entityId)) $criterias[$sqlId] = "$entityId";
        elseif ($entityId === "NULL") $criterias[$sqlId] = null;
    }
    public function addArrayCriteria(Request $request, array &$criterias, string $htmlId, string $sqlId): void
    {
        $entityIds = $request->query->all($htmlId) ?? $request->request->all($htmlId);
        $entityArray = null;
        if ($entityIds) {
            if (is_array($entityIds)) {
                $entityArray = $entityIds;
            } else {
                $entityArray = json_decode($entityIds);
            }
            $criterias[$sqlId] = $entityArray;
        }
    }
    public function getCriteriaCpu(Request $request){
        $criterias = array();
        if ($name = htmlentities($request->query->get('name') ?? ''))
            $criterias['name'] = "$name";
        $this->addCriteriaById($request, $criterias, 'cpuManufacturerId', 'manufacturer');
        $this->addCriteriaById($request, $criterias, 'cpuSpeedId', 'cpuSpeed');
        $this->addCriteriaById($request, $criterias, 'fsbSpeedId', 'fsbSpeed');
        $this->addArrayCriteria($request, $criterias, 'socketIds', 'sockets');
        $this->addArrayCriteria($request, $criterias, 'platformIds', 'platforms');
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
        if ($form['cpuSpeed']->getData()) {
            $parameters['cpuSpeedId'] = $form['cpuSpeed']->getData()->getId();
        }
        if ($form['fsbSpeed']->getData()) {
            $parameters['fsbSpeedId'] = $form['fsbSpeed']->getData()->getId();
        }

        $sockets = array_filter($form['sockets']->getData(), fn(?CpuSocket $socket) => $socket !== null);
        if (!empty($sockets)) {
            $parameters['socketIds'] = array();
            $loopCount = 0;
            foreach ($sockets  as $socket) {
                if($loopCount >= 6)
                    break;
                array_push($parameters['socketIds'], $socket->getId());
            }
        }
        $platforms = $form['platforms']->getData();
        if ($platforms) {
            $parameters['platformIds'] = array();
            $loopCount = 0;
            foreach ($platforms  as $platform) {
                if($loopCount >= 6)
                    break;
                array_push($parameters['platformIds'], $platform->getId());
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
        CpuSpeedRepository $cpuSpeedRepository,
    ): FormInterface {
        $cpuManufacturers = $manufacturerRepository->findAllProcessorManufacturer();
        $cpuSpeed = $cpuSpeedRepository->findAll();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($cpuManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'cpuManufacturers' => $cpuManufacturers,
            'cpuSpeeds' => $cpuSpeed,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
