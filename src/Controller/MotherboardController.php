<?php

namespace App\Controller;

use App\Entity\Motherboard;
use App\Entity\Manufacturer;
use App\Entity\Chipset;
use App\Entity\ProcessorPlatformType;
use App\Entity\ExpansionSlot;
use App\Entity\IoPort;
use App\Entity\MotherboardBios;
use App\Entity\DramType;
use App\Entity\Processor;
use App\Entity\CpuSpeed;
use App\Entity\MaxRam;
use App\Entity\CacheSize;
use App\Entity\VideoChipset;
use App\Entity\FormFactor;
use App\Entity\MotherboardExpansionSlot;
use App\Form\AddMotherboard;
use App\Form\SearchMotherboard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Symfony\Contracts\Translation\TranslatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Exception;

class MotherboardController extends AbstractController
{

    /**
     * @Route("/motherboard/result/", name="mobosearch", methods={"GET"})
     * @param Request $request
     */
    public function searchResult(Request $request, PaginatorInterface $paginator)
    {
        $criterias = array();
        $name = htmlentities($request->get('name'));
        if ($name) $criterias['name'] = "$name";

        $manufacturerId = htmlentities($request->get('manufacturerId'));
        if ($manufacturerId && intval($manufacturerId)) $criterias['manufacturer'] = "$manufacturerId";
        elseif($manufacturerId === "NULL") $criterias['manufacturer'] = NULL;

        $formFactorId = htmlentities($request->get('formFactorId'));
        if ($formFactorId && intval($formFactorId)) $criterias['form_factor'] = "$formFactorId";
        elseif($formFactorId === "NULL") $criterias['form_factor'] = NULL;

        $chipsetId = htmlentities($request->get('chipsetId'));
        if ($chipsetId && intval($chipsetId)) $criterias['chipset'] = "$chipsetId";
        elseif($chipsetId === "NULL") $criterias['chipset'] = NULL;

        $processorPlatformTypeId = htmlentities($request->get('processorPlatformTypeId'));
        if ($processorPlatformTypeId && intval($processorPlatformTypeId)) $criterias['processor_platform_type'] = "$processorPlatformTypeId";
        elseif($processorPlatformTypeId === "NULL") $criterias['processor_platform_type'] = NULL;
        
        //[{"id":1, "count":2}] 
        $expansionSlotsIds = $request->get('expansionSlotsIds');
        $expansionSlotsArray = NULL;
        if ($expansionSlotsIds) {
            $expansionSlotsArray = json_decode($expansionSlotsIds);
            $criterias['expansionSlots'] = $expansionSlotsArray;
        }

        //[{"id":1, "count":2}] 
        $ioPortsIds = $request->get('ioPortsIds');
        $ioPortsArray = NULL;
        if ($ioPortsIds) {
            $ioPortsArray = json_decode($ioPortsIds);
            $criterias['ioPorts'] = $ioPortsArray;
        }

        //[1, 2] 
        $biosIds = $request->get('biosIds');
        $biosArray = NULL;
        if ($biosIds) {
            $biosArray = json_decode($biosIds);
            $criterias['bios'] = $biosArray;
        }

        //[1, 2] 
        $dramTypeIds = $request->get('dramTypeIds');
        $dramTypeArray = NULL;
        if ($dramTypeIds) {
            $dramTypeArray = json_decode($dramTypeIds);
            $criterias['dram'] = $dramTypeArray;
        }

        if ($criterias == array()) {
            return $this->redirectToRoute('motherboard_search');
        }

        try {
            $data = $this->getDoctrine()
            ->getRepository(Motherboard::class)
            ->findByWithJoin($criterias, array('man1_name'=>'ASC', 'mot0_name'=>'ASC'));
        }
        catch(Exception $e) {
            return $this->redirectToRoute('motherboard_search');
        }
        $motherboards = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('motherboard/result.html.twig', [
            'controller_name' => 'MotherboardController',
            'motherboards' => $motherboards,
            'motherboard_count' => count($data),
        ]);
    }
    
    /**
    * @Route("/motherboard/show/{id}", name="motherboard_show")
    */
    public function show($id)
    {
        $motherboard = $this->getDoctrine()
            ->getRepository(Motherboard::class)
            ->find($id);

        if (!$motherboard) {
            throw $this->createNotFoundException(
                'No $motherboard found for id ' . $id
            );
        }     

        return $this->render('motherboard/show.html.twig', [
            'motherboard' => $motherboard,
            'controller_name' => 'MotherboardController',
        ]); 
    }

    /**
    * @Route("/motherboard/delete/{id}", name="motherboard_delete")
    */
    public function delete($id)
    {
        $motherboard = $this->getDoctrine()
            ->getRepository(Motherboard::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($motherboard);
        $entityManager->flush();
        return new Response("Deleted $id");
        if (!$motherboard) {
            throw $this->createNotFoundException(
                'No $motherboard found for id ' . $id
            );
        }     
    }

      /**
    * @Route("/motherboard/search", name="motherboard_search")
    * @param Request $request
    */
    public function search(Request $request, TranslatorInterface $translator)
    {
        $notIdentifiedMessage = $translator->trans("Not identified");
        $moboManufacturers = $this->getDoctrine()
            ->getRepository(Manufacturer::class)
            ->findAllMotherboardManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift ($moboManufacturers, $unidentifiedMan);

        $chipsetManufacturers = $this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->findAllChipsetManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift ($chipsetManufacturers, $unidentifiedMan);

        $chipsets = $this->getDoctrine()
            ->getRepository(Chipset::class)
            ->findAllMotherboardChipset();

        usort($chipsets, function ($a, $b)
            {
                if ($a->getFullReference() == $b->getFullReference()) {
                    return 0;
                }
                return ($a->getFullReference() < $b->getFullReference()) ? -1 : 1;
            }
        );
        
        $unidentifiedChip = new Chipset();
        $unidentifiedChip->setName($notIdentifiedMessage);
        array_unshift ($chipsets, $unidentifiedChip);

        $slots = $this->getDoctrine()
            ->getRepository(ExpansionSlot::class)
            ->findAll();

        $ports = $this->getDoctrine()
            ->getRepository(IoPort::class)
            ->findAll();
        

        $formFactors = $this->getDoctrine()
            ->getRepository(FormFactor::class)
            ->findAll();
        $unidentifiedFormFactor = new FormFactor();
        $unidentifiedFormFactor->setName($notIdentifiedMessage);
        array_unshift ($formFactors, $unidentifiedFormFactor);

        $procPlatformTypes = $this->getDoctrine()
            ->getRepository(ProcessorPlatformType::class)
            ->findBy(array(), array('name'=>'ASC'));
        /*$unidentifiedProcessorPlatformType = new ProcessorPlatformType();
        $unidentifiedProcessorPlatformType->setName("Not identified");
        array_unshift ($procPlatformTypes, $unidentifiedProcessorPlatformType);*/

        $biosManufacturers = $this->getDoctrine()
            ->getRepository(Manufacturer::class)
            ->findAllBiosManufacturer();

        $slotsForm = array();
        foreach($slots as $k => $slotForm) {
            $expSlot = array("expansion_slot"=>$slotForm,"count"=>0);
            array_push($slotsForm, $expSlot);
        }
        $portsForm = array();
        foreach($ports as $k => $portForm) {
            $ioPort = array("io_port"=>$portForm,"count"=>0);
            array_push($portsForm, $ioPort);
        }
        //dd(array($slotsForm));
        $form = $this->createForm(SearchMotherboard::class, array('motherboardExpansionSlots'=>$slotsForm,'motherboardIoPorts'=>$portsForm), [
            'moboManufacturers' => $moboManufacturers,
            'chipsetManufacturers' => $chipsetManufacturers,
            'chipsets' => $chipsets,
            'formFactors' => $formFactors,
            'procPlatformTypes' => $procPlatformTypes,
            'bios' => $biosManufacturers,
            ]);
        //dd($form);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $parameters = array();
            //dd($form->getData());
            if ($form['manufacturer']->getData()) {
                if($form['manufacturer']->getData()->getId() == 0){
                    $parameters['manufacturerId']  = "NULL";
                }
                else {
                    $parameters['manufacturerId'] = $form['manufacturer']->getData()->getId();
                }
            }
            /*if($form['searchManufacturer']->getData()){
                if ($form['manufacturer']->getData()) {
                    $parameters['manufacturerId'] = $form['manufacturer']->getData()->getId();
                }
                else {
                    $parameters['manufacturerId']  = "NULL";
                }
            }*/

            if($form['name']->getData()) {
                    $parameters['name'] = $form['name']->getData();
            }

            if ($form['formFactor']->getData()) {
                if($form['formFactor']->getData()->getId() == 0){
                    $parameters['formFactorId']  = "NULL";
                }
                else {
                    $parameters['formFactorId'] = $form['formFactor']->getData()->getId();
                }
            }

            /*if($form['searchFormFactor']->getData()){
                if ($form['formFactor']->getData()) {
                    $parameters['formFactorId'] = $form['formFactor']->getData()->getId();
                }
                else {
                    $parameters['formFactorId']  = "NULL";
                }
            }*/

            if ($form['chipset']->getData()) {
                if($form['chipset']->getData()->getId() == 0) {
                    $parameters['chipsetId']  = "NULL";
                }
                else {
                    $parameters['chipsetId'] = $form['chipset']->getData()->getId();
                }
               
            }

            /*if($form['searchChipset']->getData()){
                if ($form['chipset']->getData()) {
                    $parameters['chipsetId'] = $form['chipset']->getData()->getId();
                }
                else {
                    $parameters['chipsetId']  = "NULL";
                }
            }*/

            if ($form['processorPlatformType']->getData()) {
                /*if ($form['processorPlatformType']->getData()->getId() == 0) {
                    $parameters['processorPlatformTypeId']  = "NULL";
                }
                else {*/
                    $parameters['processorPlatformTypeId'] = $form['processorPlatformType']->getData()->getId();
                //}
            }

            /*if($form['searchProcessorPlatformType']->getData()){
                if ($form['processorPlatformType']->getData()) {
                    $parameters['processorPlatformTypeId'] = $form['processorPlatformType']->getData()->getId();
                }
                else {
                    $parameters['processorPlatformTypeId']  = "NULL";
                }
            }*/
            
            $expansionSlots = array();
            foreach($slots as $key => $slot) {
                $count = $request->request->get('slot' . $slot->getId());
                if($count != 0) {
                    $sloCount = array('id' => $slot->getId(), 'count' => $count);
                    array_push($expansionSlots, $sloCount); 
                }
                else if($count == '0') {
                    $sloCount = array('id' => $slot->getId(), 'count' => null);
                    array_push($expansionSlots, $sloCount); 
                }
                
            }

            $ioPorts = array();
            foreach($ports as $key => $port) {
                $count = $request->request->get('port' . $port->getId());
                if($count != 0) {
                    $porCount = array('id' => $port->getId(), 'count' => $count);
                    array_push($ioPorts, $porCount); 
                }
                else if($count == '0') {
                    $porCount = array('id' => $port->getId(), 'count' => null);
                    array_push($ioPorts, $porCount); 
                }
            }
           /* foreach($form['motherboardExpansionSlots']->getData() as $key => $moboSlot) {
                if($moboSlot['count'] != NULL) {
                    $slot = array('id' => $moboSlot['expansion_slot']->getId(), 'count' => $moboSlot['count']);
                    array_push($expansionSlots, $slot); 
                }
            }*/
            if (count($expansionSlots) > 0)
                $parameters['expansionSlotsIds'] = json_encode($expansionSlots);

            /*$ioPorts = array();
            foreach($form['motherboardIoPorts']->getData() as $key => $moboIo) {
                if($moboIo['count'] != NULL) {
                    $port = array('id' => $moboIo['io_port']->getId(), 'count' => $moboIo['count']);
                    array_push($ioPorts, $port);
                }
            }*/

            if (count($ioPorts) > 0)
                $parameters['ioPortsIds'] = json_encode($ioPorts);

            $dramTypes = array();
            foreach($form['dramType']->getData() as $key => $dram) {
                array_push($dramTypes, $dram->getId()); 
            }
            if (count($dramTypes) > 0)
                $parameters['dramTypeIds'] = json_encode($dramTypes);

            $bioses = array();
            foreach($form['motherboardBios']->getData() as $key => $bios) {
                array_push($bioses, $bios->getId()); 
            }
            if (count($bioses) > 0)
                $parameters['biosIds'] = json_encode($bioses);

            //return new Response();
            //return $this->redirect('/motherboard/show/' . $mobo->getId());
            return $this->redirectToRoute('mobosearch', $parameters);
        }
        return $this->render('motherboard/search.html.twig', [
            'form' => $form->createView(),
            'slots' => $slots,
            'ports' => $ports,
        ]);
    }

    private function renderAddForm(Request $request, Motherboard $mobo) {
        $entityManager = $this->getDoctrine()->getManager();

        $chipsets = $this->getDoctrine()
            ->getRepository(Chipset::class)
            ->findAllChipsetManufacturer();

        usort($chipsets, function ($a, $b)
            {
                if ($a->getMainChipWithManufacturer() == $b->getMainChipWithManufacturer()) {
                    return 0;
                }
                return ($a->getMainChipWithManufacturer() < $b->getMainChipWithManufacturer()) ? -1 : 1;
            }
        );
        
        $cpus = $this->getDoctrine()
            ->getRepository(Processor::class)
            ->findAll();

        usort($cpus, function ($a, $b)
            {
                if ($a->getNameWithPlatform() == $b->getNameWithPlatform()) {
                    return 0;
                }
                return ($a->getNameWithPlatform() < $b->getNameWithPlatform()) ? -1 : 1;
            }
        );
        
        $procPlatformTypes = $this->getDoctrine()
            ->getRepository(ProcessorPlatformType::class)
            ->findBy(array(), array('name'=>'ASC'));

        
        $form = $this->createForm(AddMotherboard::class, $mobo, [
            'chipsets' => $chipsets,
            'cpus' => $cpus,
            'procPlatformTypes' => $procPlatformTypes,
        ]);
        //dd($form);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mobo = $form->getData();
            $mobo->updateLastEdited();
            foreach ($form['motherboardAliases']->getData() as $key => $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['motherboardIoPorts']->getData() as $key => $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['motherboardExpansionSlots']->getData() as $key => $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['manuals']->getData() as $key => $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['motherboardBios']->getData() as $key => $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['images']->getData() as $key => $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['motherboardMaxRams']->getData() as $key => $val) {
                $val->setMotherboard($mobo);
            }
            if ($mobo->getManufacturer() != NULL && $mobo->getManufacturer()->getId() == 0) {
                $mobo->setManufacturer(NULL);
            }
            //dd($mobo);
            $entityManager->persist($mobo);

            $entityManager->flush();

            return $this->redirectToRoute('motherboard_show', array('id' => $mobo->getId()));
        }
        return $this->render('motherboard/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/motherboard/add", name="motherboard_add")
    * @param Request $request
    */
    public function add(Request $request)
    {
        return $this->renderAddForm($request, new Motherboard());
    }

     /**
    * @Route("/motherboard/edit/{id}", name="motherboard_edit", requirements={"id"="\d+"})
    * @param Request $request
    */
    public function edit(Request $request, int $id)
    {
        return $this->renderAddForm($request, $this->getDoctrine()
            ->getRepository(Motherboard::class)
            ->find($id)
        );

    }

    /**
     * @Route("/motherboard/index/{letter}", name="moboindex", requirements={"letter"="\w"}), methods={"GET"})
     * @param Request $request
     */
    public function index(Request $request, PaginatorInterface $paginator, string $letter = '')
    {
        $data = $this->getDoctrine()
        ->getRepository(Motherboard::class)
        ->findAllAlphabetic($letter);

        if ($data == array()) {
            return $this->redirectToRoute('motherboard_search');
        }

        usort($data, function ($a, $b)
            {
                if ($a->getManufacturerShortNameIfExist() == $b->getManufacturerShortNameIfExist()) {
                    return 0;
                }
                return ($a->getManufacturerShortNameIfExist() < $b->getManufacturerShortNameIfExist()) ? -1 : 1;
            }
        );

        $motherboards = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('motherboard/index.html.twig', [
            'motherboards' => $motherboards,
        ]);
    }
}