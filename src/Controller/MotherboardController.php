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
use App\Entity\CpuSocket;
use App\Form\Motherboard\Search;
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
        $name = htmlentities($request->query->get('name'));
        if ($name) $criterias['name'] = "$name";

        $manufacturerId = htmlentities($request->query->get('manufacturerId'));
        if ($manufacturerId && intval($manufacturerId)) $criterias['manufacturer'] = "$manufacturerId";
        elseif($manufacturerId === "NULL") $criterias['manufacturer'] = NULL;

        $formFactorId = htmlentities($request->query->get('formFactorId'));
        if ($formFactorId && intval($formFactorId)) $criterias['form_factor'] = "$formFactorId";
        elseif($formFactorId === "NULL") $criterias['form_factor'] = NULL;

        $chipsetId = htmlentities($request->query->get('chipsetId'));
        if ($chipsetId && intval($chipsetId)) $criterias['chipset'] = "$chipsetId";
        elseif($chipsetId === "NULL") $criterias['chipset'] = NULL;

        $cpuSocket1 = htmlentities($request->query->get('cpuSocket1'));
        if ($cpuSocket1 && intval($cpuSocket1)) $criterias['cpu_socket1'] = "$cpuSocket1";
        elseif($cpuSocket1 === "NULL") $criterias['cpu_socket1'] = NULL;

        $platform1 = htmlentities($request->query->get('platform1'));
        if ($platform1 && intval($platform1)) $criterias['processor_platform_type1'] = "$platform1";
        elseif($platform1 === "NULL") $criterias['processor_platform_type1'] = NULL;

        $cpuSocket2 = htmlentities($request->query->get('cpuSocket2'));
        if ($cpuSocket2 && intval($cpuSocket2)) $criterias['cpu_socket2'] = "$cpuSocket2";
        elseif($cpuSocket2 === "NULL") $criterias['cpu_socket2'] = NULL;

        $platform2 = htmlentities($request->query->get('platform2'));
        if ($platform2 && intval($platform2)) $criterias['processor_platform_type2'] = "$platform2";
        elseif($platform2 === "NULL") $criterias['processor_platform_type2'] = NULL;

        $chipsetManufacturerId = htmlentities($request->query->get('chipsetManufacturerId'));
        if ($chipsetManufacturerId && intval($chipsetManufacturerId) && !array_key_exists('chipset', $criterias)) $criterias['chipsetManufacturer'] = "$chipsetManufacturerId";
        elseif($chipsetManufacturerId === "NULL" && !array_key_exists('chipset', $criterias)) $criterias['chipsetManufacturer'] = NULL;

        $showImages = boolval(htmlentities($request->query->get('showImages')));
        
        //[{"id":1, "count":2}] 
        $expansionSlotsIds = $request->query->get('expansionSlotsIds');
        $expansionSlotsArray = NULL;
        if ($expansionSlotsIds) {
            $expansionSlotsArray = json_decode($expansionSlotsIds);
            $criterias['expansionSlots'] = $expansionSlotsArray;
        }

        //[{"id":1, "count":2}] 
        $ioPortsIds = $request->query->get('ioPortsIds');
        $ioPortsArray = NULL;
        if ($ioPortsIds) {
            $ioPortsArray = json_decode($ioPortsIds);
            $criterias['ioPorts'] = $ioPortsArray;
        }

        //[1, 2] 
        $biosIds = $request->query->get('biosIds');
        $biosArray = NULL;
        if ($biosIds) {
            $biosArray = json_decode($biosIds);
            $criterias['bios'] = $biosArray;
        }

        //[1, 2] 
        $dramTypeIds = $request->query->get('dramTypeIds');
        $dramTypeArray = NULL;
        if ($dramTypeIds) {
            $dramTypeArray = json_decode($dramTypeIds);
            $criterias['dram'] = $dramTypeArray;
        }

        
        if ($criterias == array()) {
            return $this->redirectToRoute('motherboard_search');
        }
        
        //dd($criterias);
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
            'show_images' => $showImages,
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

        $slots = $this->getDoctrine()
            ->getRepository(ExpansionSlot::class)
            ->findAll();

        $ports = $this->getDoctrine()
            ->getRepository(IoPort::class)
            ->findAll();
        
        $cpuSockets = $this->getDoctrine()
        ->getRepository(CpuSocket::class)
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
        
        $form = $this->createForm(Search::class, array(), [
            'moboManufacturers' => $moboManufacturers,
            'chipsetManufacturers' => $chipsetManufacturers,
            'formFactors' => $formFactors,
            'procPlatformTypes' => $procPlatformTypes,
            'bios' => $biosManufacturers,
            'cpuSockets' => $cpuSockets,
            ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            if($form->get('searchChipsetManufacturer')->isClicked() || $form->get('searchSocket1')->isClicked() || $form->get('searchSocket2')->isClicked()){
                return $this->render('motherboard/search.html.twig', [
                    'form' => $form->createView(),
                    'slots' => $slots,
                    'ports' => $ports,
                ]);
            }
            
            return $this->redirect($this->generateUrl('mobosearch', $this->searchFormToParam($request, $form, $slots, $ports)));
        }
        return $this->render('motherboard/search.html.twig', [
            'form' => $form->createView(),
            'slots' => $slots,
            'ports' => $ports,
        ]);
    }

    private function searchFormToParam(Request $request, $form, $slots, $ports) : array {
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

            if ($form['searchWithImages']->isClicked()){
                $parameters['showImages'] = true;
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

            /*$bioses = array();
            foreach($form['motherboardBios']->getData() as $key => $bios) {
                array_push($bioses, $bios->getId()); 
            }
            if (count($bioses) > 0)
                $parameters['biosIds'] = json_encode($bioses);*/

            if ($form['chipsetManufacturer']->getData() && !$form['chipset']->getData()) {

                if($form['chipsetManufacturer']->getData()->getId() == 0) {
                    $parameters['chipsetManufacturerId']  = "NULL";
                }
                else {
                    $parameters['chipsetManufacturerId'] = $form['chipsetManufacturer']->getData()->getId();
                }
            }

            return $parameters;
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