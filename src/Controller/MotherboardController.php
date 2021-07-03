<?php

namespace App\Controller;

use App\Entity\Motherboard;
use App\Entity\Manufacturer;
use App\Entity\ProcessorPlatformType;
use App\Entity\ExpansionSlot;
use App\Entity\IoPort;
use App\Entity\FormFactor;
use App\Entity\CpuSocket;
use App\Form\Motherboard\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Exception;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MotherboardController extends AbstractController
{

    /**
     * @Route("/motherboard/result/", methods={"GET"})
     * @param Request $request
     */
    public function redirectSearch(Request $request)
    {
        return $this->redirect($this->generateUrl('mobosearch', $request->query->all()));
    }

    /**
    * @Route("/motherboard/show/{id}")
    */
    public function redirectShow($id)
    {
        return $this->redirect($this->generateUrl('motherboard_show', array("id" => $id)));
    }

    /**
     * @Route("/motherboard/search/")
     * @param Request $request
     */
    public function redirectNewSearch()
    {
        return $this->redirect($this->generateUrl('motherboard_search'));
    }

    /**
     * @Route("/motherboard/index/{letter}", requirements={"letter"="\w"}), methods={"GET"})
     * @param Request $request
     */
    public function redirectIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('moboindex', array_merge($request->query->all(), array("letter" => $letter))));
    }

    /**
     * @Route("/motherboards/", name="mobosearch", methods={"GET"})
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
            if (is_array($expansionSlotsIds))
                $expansionSlotsArray = $expansionSlotsIds;
            else
                $expansionSlotsArray = json_decode($expansionSlotsIds);
            $criterias['expansionSlots'] = $expansionSlotsArray;
        }

        //[{"id":1, "count":2}] 
        $ioPortsIds = $request->query->get('ioPortsIds');
        $ioPortsArray = NULL;
        if ($ioPortsIds) {
            if (is_array($ioPortsIds))
                $ioPortsArray = $ioPortsIds;
            else
                $ioPortsArray = json_decode($ioPortsIds);
            $criterias['ioPorts'] = $ioPortsArray;
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
    * @Route("/motherboards/{id}", name="motherboard_show", requirements={"id"="\d+"})
    */
    public function show(int $id)
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
    * @Route("/motherboards/{id}/delete/", name="motherboard_delete", requirements={"id"="\d+"})
    * @param Request $request
    */
    public function delete(Request $request, int $id)
    {
        $motherboard = $this->getDoctrine()
            ->getRepository(Motherboard::class)
            ->find($id);

        if (!$motherboard) {
            throw $this->createNotFoundException(
                'No $motherboard found for id ' . $id
            );
        }

        $form = $this->createFormBuilder()
        ->add('No', SubmitType::class)
        ->add('Yes', SubmitType::class)
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('No')->isClicked())
            {
                return $this->redirect($this->generateUrl('motherboard_show', array("id" => $id)));
            }
            if ($form->get('Yes')->isClicked())
            {
                $entityManager = $this->getDoctrine()->getManager();
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

      /**
    * @Route("/motherboards/search/", name="motherboard_search")
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

        $parameters['name'] = $form['name']->getData();

        if ($form['formFactor']->getData()) {
            if($form['formFactor']->getData()->getId() == 0){
                $parameters['formFactorId']  = "NULL";
            }
            else {
                $parameters['formFactorId'] = $form['formFactor']->getData()->getId();
            }
        }

        if ($form['chipset']->getData()) {
            if($form['chipset']->getData()->getId() == 0) {
                $parameters['chipsetId']  = "NULL";
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
        
        $parameters['expansionSlotsIds'] = array();
        foreach($slots as $key => $slot) {
            $count = $request->request->get('slot' . $slot->getId());
            if($count != 0) {
                $sloCount = array('id' => $slot->getId(), 'count' => $count);
                array_push($parameters['expansionSlotsIds'], $sloCount); 
            }
            else if($count == '0') {
                $sloCount = array('id' => $slot->getId(), 'count' => null);
                array_push($parameters['expansionSlotsIds'], $sloCount); 
            }
            
        }
        //$parameters['expansionSlotsIds'] = $expansionSlots;

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
        $parameters['ioPortsIds'] = $ioPorts;

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
     * @Route("/motherboards/index/{letter}", name="moboindex", requirements={"letter"="\w"}), methods={"GET"})
     * @param Request $request
     */
    public function index(Request $request, PaginatorInterface $paginator, string $letter = '')
    {
        //dd($letter);
        $data = $this->getDoctrine()
        ->getRepository(Motherboard::class)
        ->findAllAlphabetic($letter);

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