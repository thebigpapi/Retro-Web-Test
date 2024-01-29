<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Entity\FormFactor;
use App\Entity\MotherboardIdRedirection;
use App\Form\Motherboard\Search;
use App\Repository\CpuSocketRepository;
use App\Repository\FormFactorRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\MotherboardIdRedirectionRepository;
use App\Repository\MotherboardRepository;
use App\Repository\ProcessorPlatformTypeRepository;
use App\Repository\ExpansionChipTypeRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\ClickableInterface;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class MotherboardController extends AbstractController
{
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
    public function getCriteria(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) $criterias['name'] = "$name";
        $this->addCriteriaById($request, $criterias, 'manufacturerId', 'manufacturer');
        $this->addCriteriaById($request, $criterias, 'formFactorId', 'form_factor');
        $this->addCriteriaById($request, $criterias, 'chipsetId', 'chipset');
        if(!array_key_exists('chipset', $criterias)){
            $this->addCriteriaById($request, $criterias, 'chipsetManufacturerId', 'chipsetManufacturer');
        }
        $this->addCriteriaById($request, $criterias, 'cpuSocket1', 'cpu_socket1');
        $this->addCriteriaById($request, $criterias, 'cpuSocket2', 'cpu_socket2');
        $this->addCriteriaById($request, $criterias, 'platform1', 'processor_platform_type1');
        $this->addCriteriaById($request, $criterias, 'platform2', 'processor_platform_type2');
        $this->addArrayCriteria($request, $criterias, 'expansionSlotsIds', 'expansionSlots');
        $this->addArrayCriteria($request, $criterias, 'ioPortsIds', 'ioPorts');
        $this->addArrayCriteria($request, $criterias, 'expansionChipIds', 'expansionChips');
        $this->addArrayCriteria($request, $criterias, 'dramTypeIds', 'dramTypes');
        return $criterias;
    }

    #[Route('/motherboards/', name: 'mobosearch', methods: ['GET', 'POST'])]
    public function searchResult(
        Request $request,
        PaginatorInterface $paginator,
        MotherboardRepository $motherboardRepository,
        ManufacturerRepository $manufacturerRepository,
        CpuSocketRepository $cpuSocketRepository,
        FormFactorRepository $formFactorRepository,
        ProcessorPlatformTypeRepository $processorPlatformTypeRepository
    ): Response {
        $form = $this->_searchFormHandler($request, $manufacturerRepository, $cpuSocketRepository,
            $formFactorRepository, $processorPlatformTypeRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('mobosearch', $this->searchFormToParam($request, $form)));
        }
        $criterias = $this->getCriteria($request);

        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('motherboard/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $data = $motherboardRepository->findByWithJoin($criterias);
        $motherboards = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('motherboard/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'MotherboardController',
            'motherboards' => $motherboards,
            'show_images' => $showImages,
        ]);
    }

    #[Route('/motherboards/results', name: 'mobolivesearch')]
    public function liveResults(
        Request $request,
        PaginatorInterface $paginator,
        MotherboardRepository $motherboardRepository
    ): Response {
        $criterias = $this->getCriteria($request);

        $showImages = boolval(htmlentities($request->query->get('showImages') ??
            ($request->request->get('showImages') ?? '')));

        $data = $motherboardRepository->findByWithJoin($criterias);
        $maxItems = $request->query->getInt('itemsPerPage',
            $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $motherboards = $paginator->paginate(
            $data,
            $request->query->getInt('page', $request->request->getInt('page', 1)),
            $maxItems
        );
        $string = "/motherboards/?";
        foreach ($request->query as $key => $value){
            if($key == "expansionSlotsIds" || $key == "ioPortsIds"){
                foreach($value as $idx => $property){
                    foreach($property as $type=> $val){
                        $string .= $key . '%5B' . $idx . '%5D%5B' . $type . '%5D=' . $val .'&';
                    }
                }
            }
            else if($key == "expansionChipIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else if($key == "dramTypeIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else{
                if($key != "domTarget")
                    $string .= $key . '=' . $value . '&';
            }
        }
        return $this->render('motherboard/result.html.twig', [
            'controller_name' => 'MotherboardController',
            'motherboards' => $motherboards,
            'motherboard_count' => count($data),
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }

    #[Route('/motherboards/s/{slug}', name: 'motherboard_show_slug')]
    public function showSlug(
        string $slug,
        MotherboardRepository $motherboardRepository,
        MotherboardIdRedirectionRepository $motherboardIdRedirectionRepository,
        ExpansionChipTypeRepository $expansionchiptyperep
    ): Response {
        $motherboard = $motherboardRepository->findSlug($slug);
        $expansionchiptype = $expansionchiptyperep->findAll();

        if (!$motherboard) {
            $idRedirection = $motherboardIdRedirectionRepository->findRedirection($slug, 'uh19_slug');

            if (!$idRedirection) {
                throw $this->createNotFoundException(
                    'No $motherboard found for slug ' . $slug
                );
            } else {
                return $this->redirect($this->generateUrl('motherboard_show', array("id" => $idRedirection)));
            }
        }

        return $this->render('motherboard/show.html.twig', [
            'motherboard' => $motherboard,
            'expansionchiptype' => $expansionchiptype,
            'controller_name' => 'MotherboardController',
        ]);
    }

    #[Route('/motherboards/{id}', name: 'motherboard_show', requirements: ['id' => '\d+'])]
    public function show(
        int $id,
        MotherboardRepository $motherboardRepository,
        MotherboardIdRedirectionRepository $motherboardIdRedirectionRepository
    ): Response {
        $motherboard = $motherboardRepository->find($id);

        if (!$motherboard) {
            $idRedirection = $motherboardIdRedirectionRepository->findRedirection($id, 'uh19');

            if (!$idRedirection) {
                throw $this->createNotFoundException(
                    'No $motherboard found for id ' . $id
                );
            } else {
                return $this->redirect($this->generateUrl('motherboard_show', array("id" => $idRedirection)));
            }
        }

        return $this->redirect($this->generateUrl('motherboard_show_slug', array("slug" => $motherboard->getSlug())));
    }

    #[Route('/dashboard/motherboard-delete/{id}', name: 'motherboard_delete', requirements: ["id" => "\d+"])]
    public function delete(
        Request $request,
        int $id,
        MotherboardRepository $motherboardRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $motherboard = $motherboardRepository->find($id);

        if (!$motherboard) {
            throw $this->createNotFoundException(
                'No $motherboard found for id ' . $id
            );
        }
        $slug = $motherboard->getSlug();

        $form = $this->createFormBuilder()
            ->add('No', SubmitType::class)
            ->add('Yes', SubmitType::class)
            ->add('Redirection', NumberType::class, [
                'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var ClickableInterface
             */
            $noButton = $form->get('No');
            /**
             * @var ClickableInterface
             */
            $yesButton = $form->get('Yes');
            if ($noButton->isClicked()) {
                return $this->redirect($this->generateUrl('motherboard_show', array("id" => $id)));
            }
            if ($yesButton->isClicked()) {
                //If user selected a motherboard where the current id will redirect to
                if ($form->get('Redirection') && !is_null($form->get('Redirection')->getData())) {
                    $idRedirection = $form->get('Redirection')->getData();
                    $destinationMotherboard = $motherboardRepository->find($idRedirection);


                    if ($destinationMotherboard) {
                        //Creating new redirection
                        $redirection = new MotherboardIdRedirection();
                        $redirection->setSource($id);
                        $redirection->setSourceType('uh19');
                        $redirection->setDestination($destinationMotherboard);

                        $slugRedirection = new MotherboardIdRedirection();
                        $slugRedirection->setSource($slug);
                        $slugRedirection->setSourceType('uh19_slug');
                        $slugRedirection->setDestination($destinationMotherboard);

                        $entityManager->persist($redirection);
                        $entityManager->persist($slugRedirection);

                        //Moving each old redirection to the destination motherboard
                        foreach ($motherboard->getRedirections()->toArray() as $redirection) {
                            $newRedirection = new MotherboardIdRedirection();
                            $newRedirection->setSource($redirection->getSource());
                            $newRedirection->setSourceType($redirection->getSourceType());
                            $newRedirection->setDestination($destinationMotherboard);
                            $entityManager->persist($newRedirection);
                        }
                    } else {
                        throw $this->createNotFoundException(
                            'No $motherboard found for id ' . $idRedirection
                        );
                    }
                }
                //Deleting the motherboard
                $entityManager->remove($motherboard);
                $entityManager->flush();
                return $this->render('motherboard/delete_confirm.html.twig', [
                    'id' => $id,
                ]);
            }
        }

        return $this->render('motherboard/delete.html.twig', [
            'form' => $form->createView(),
            'motherboard' => $motherboard,
        ]);
    }

    #[Route('/motherboards/live', name: 'mobolivewrapper')]
    public function liveSearch(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        CpuSocketRepository $cpuSocketRepository,
        FormFactorRepository $formFactorRepository,
        ProcessorPlatformTypeRepository $processorPlatformTypeRepository
    ): Response {
        $form = $this->_searchFormHandler($request, $manufacturerRepository, $cpuSocketRepository,
            $formFactorRepository, $processorPlatformTypeRepository);

        return $this->redirect($this->generateUrl('mobolivesearch', $this->searchFormToParam($request, $form)));
    }

    private function searchFormToParam(Request $request, FormInterface $form): array
    {
        $parameters = array();
        if ($form['manufacturer']->getData()) {
            if ($form['manufacturer']->getData()->getId() == 0) {
                $parameters['manufacturerId']  = "NULL";
            } else {
                $parameters['manufacturerId'] = $form['manufacturer']->getData()->getId();
            }
        }

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['showImages'] = $form['searchWithImages']->getData();
        $parameters['name'] = $form['name']->getData();

        if ($form['formFactor']->getData()) {
            if ($form['formFactor']->getData()->getId() == 0) {
                $parameters['formFactorId']  = "NULL";
            } else {
                $parameters['formFactorId'] = $form['formFactor']->getData()->getId();
            }
        }

        if ($form['chipset']->getData()) {
            if ($form['chipset']->getData()->getId() == 0) {
                if ($form['chipset']->getData()->getName() == " chipset of any kind"){
                    $parameters['chipsetManufacturerId'] = $form['chipset']->getData()->getManufacturer()->getId();
                }
                else{
                    $parameters['chipsetId']  = "NULL";
                }
            }
            else {
                $parameters['chipsetId'] = $form['chipset']->getData()->getId();
            }

        }

        if ($form['cpuSocket1']->getData()) {
            $parameters['cpuSocket1'] = $form['cpuSocket1']->getData()->getId();
        }

        if ($form['platform1']->getData()) {
            $parameters['platform1'] = $form['platform1']->getData()->getId();
        }

        if ($form['cpuSocket2']->getData()) {
            $parameters['cpuSocket2'] = $form['cpuSocket2']->getData()->getId();
        }

        if ($form['platform2']->getData()) {
            $parameters['platform2'] = $form['platform2']->getData()->getId();
        }
        $slots = $form['motherboardExpansionSlots']->getData();
        if ($slots) {
            $parameters['expansionSlotsIds'] = array();
            $loopCount = 0;
            foreach ($slots as $slot) {
                if($loopCount >= 6)
                    break;
                $loopCount++;
                $countArray = $this->convertCount($slot['count']);
                if ($countArray['value'] !== 0) {
                    $slotCount = array('id' => $slot['expansion_slot']->getId(), 'count' => $countArray['value'], 'sign' => $countArray['sign']);
                    array_push($parameters['expansionSlotsIds'], $slotCount);
                } elseif ($countArray['value'] == 0) {
                    $slotCount = array('id' => $slot['expansion_slot']->getId(), 'count' => null, 'sign' => '=');
                    array_push($parameters['expansionSlotsIds'], $slotCount);
                }
            }
        }

        $ports = $form['motherboardIoPorts']->getData();
        if ($ports) {
            $parameters['ioPortsIds'] = array();
            $loopCount = 0;
            foreach ($ports as $port) {
                if($loopCount >= 6)
                    break;
                $loopCount++;
                $countArray = $this->convertCount($port['count']);
                if ($countArray['value'] !== 0) {
                    $portCount = array('id' => $port['io_port']->getId(), 'count' => $countArray['value'], 'sign' => $countArray['sign']);
                    array_push($parameters['ioPortsIds'], $portCount);
                } elseif ($countArray['value']== 0) {
                    $portCount = array('id' => $port['io_port']->getId(), 'count' => null, 'sign' => '=');
                    array_push($parameters['ioPortsIds'], $portCount);
                }
            }
        }

        $expchips = $form['expansionChips']->getData();
        if ($expchips) {
            $parameters['expansionChipIds'] = array();
            $loopCount = 0;
            foreach ($expchips as $chip) {
                if($loopCount >= 6)
                    break;
                $loopCount++;
                array_push($parameters['expansionChipIds'], $chip->getId());
            }
        }
        $dramtypes = $form['dramTypes']->getData();
        if ($dramtypes) {
            $parameters['dramTypeIds'] = array();
            foreach ($dramtypes as $type) {
                array_push($parameters['dramTypeIds'], $type->getId());
            }
        }
        return $parameters;
    }

    private function _searchFormHandler(
        Request $request,
        ManufacturerRepository $manufacturerRepository,
        CpuSocketRepository $cpuSocketRepository,
        FormFactorRepository $formFactorRepository,
        ProcessorPlatformTypeRepository $processorPlatformTypeRepository
    ): FormInterface {
        $notIdentifiedMessage = "Unidentified";
        $moboManufacturers = $manufacturerRepository->findAllMotherboardManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($moboManufacturers, $unidentifiedMan);

        $chipsetManufacturers = $manufacturerRepository->findAllChipsetManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($chipsetManufacturers, $unidentifiedMan);

        $cpuSockets = $cpuSocketRepository->findAll();

        $formFactors = $formFactorRepository->findAll();
        $unidentifiedFormFactor = new FormFactor();
        $unidentifiedFormFactor->setName($notIdentifiedMessage);
        array_unshift($formFactors, $unidentifiedFormFactor);

        $procPlatformTypes = $processorPlatformTypeRepository->findBy(array(), array('name' => 'ASC'));

        $biosManufacturers = $manufacturerRepository->findAllBiosManufacturer();

        $form = $this->createForm(Search::class, array(), [
            'moboManufacturers' => $moboManufacturers,
            'chipsetManufacturers' => $chipsetManufacturers,
            'formFactors' => $formFactors,
            'procPlatformTypes' => $procPlatformTypes,
            'bios' => $biosManufacturers,
            'cpuSockets' => $cpuSockets,
        ]);

        $form->handleRequest($request);

        return $form;
    }
    public function convertCount($input): array
    {
        $output = array();
        $output['valid'] = true;
        $nospaces = html_entity_decode(preg_replace("/\s+/", "", $input));
        $sign = preg_replace('/[^><=]/', '', $nospaces);
        $numbers = preg_replace('/[^0-9]/', '', $nospaces);
        if($numbers == "")
            $output['valid'] = false;
        $output['value'] = (int)$numbers;
        $output['sign'] = '=';
        if($sign == "<")
            $output['sign'] = '<';
        if($sign == ">")
            $output['sign'] = '>';
        if($sign == ">=")
            $output['sign'] = '>=';
        if($sign == "<=")
            $output['sign'] = '<=';
        return $output;
    }
}
