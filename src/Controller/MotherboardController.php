<?php

namespace App\Controller;

use App\Entity\Motherboard;
use App\Entity\Manufacturer;
use App\Entity\ProcessorPlatformType;
use App\Entity\ExpansionSlot;
use App\Entity\IoPort;
use App\Entity\FormFactor;
use App\Entity\CpuSocket;
use App\Entity\IdRedirection;
use App\Entity\MotherboardIdRedirection;
use App\Form\Motherboard\Search;
use App\Repository\MotherboardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Exception;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
        return $this->redirect($this->generateUrl('moboindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
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
        elseif ($manufacturerId === "NULL") $criterias['manufacturer'] = null;

        $formFactorId = htmlentities($request->query->get('formFactorId'));
        if ($formFactorId && intval($formFactorId)) $criterias['form_factor'] = "$formFactorId";
        elseif ($formFactorId === "NULL") $criterias['form_factor'] = null;

        $chipsetId = htmlentities($request->query->get('chipsetId'));
        if ($chipsetId && intval($chipsetId)) $criterias['chipset'] = "$chipsetId";
        elseif ($chipsetId === "NULL") $criterias['chipset'] = null;

        $cpuSocket1 = htmlentities($request->query->get('cpuSocket1'));
        if ($cpuSocket1 && intval($cpuSocket1)) $criterias['cpu_socket1'] = "$cpuSocket1";
        elseif ($cpuSocket1 === "NULL") $criterias['cpu_socket1'] = null;

        $platform1 = htmlentities($request->query->get('platform1'));
        if ($platform1 && intval($platform1)) $criterias['processor_platform_type1'] = "$platform1";
        elseif ($platform1 === "NULL") $criterias['processor_platform_type1'] = null;

        $cpuSocket2 = htmlentities($request->query->get('cpuSocket2'));
        if ($cpuSocket2 && intval($cpuSocket2)) $criterias['cpu_socket2'] = "$cpuSocket2";
        elseif ($cpuSocket2 === "NULL") $criterias['cpu_socket2'] = null;

        $platform2 = htmlentities($request->query->get('platform2'));
        if ($platform2 && intval($platform2)) $criterias['processor_platform_type2'] = "$platform2";
        elseif ($platform2 === "NULL") $criterias['processor_platform_type2'] = null;

        $chipsetManufacturerId = htmlentities($request->query->get('chipsetManufacturerId'));
        if (
            $chipsetManufacturerId
            &&
            intval($chipsetManufacturerId)
            &&
            !array_key_exists('chipset', $criterias)
        ) {
            $criterias['chipsetManufacturer'] = "$chipsetManufacturerId";
        } elseif ($chipsetManufacturerId === "NULL" && !array_key_exists('chipset', $criterias)) {
            $criterias['chipsetManufacturer'] = null;
        }

        $showImages = boolval(htmlentities($request->query->get('showImages')));

        //[{"id":1, "count":2}]
        $expansionSlotsIds = $request->query->get('expansionSlotsIds');
        $expansionSlotsArray = null;
        if ($expansionSlotsIds) {
            if (is_array($expansionSlotsIds)) {
                $expansionSlotsArray = $expansionSlotsIds;
            } else {
                $expansionSlotsArray = json_decode($expansionSlotsIds);
            }
            $criterias['expansionSlots'] = $expansionSlotsArray;
        }

        //[{"id":1, "count":2}]
        $ioPortsIds = $request->query->get('ioPortsIds');
        $ioPortsArray = null;
        if ($ioPortsIds) {
            if (is_array($ioPortsIds)) {
                $ioPortsArray = $ioPortsIds;
            } else {
                $ioPortsArray = json_decode($ioPortsIds);
            }
            $criterias['ioPorts'] = $ioPortsArray;
        }

        if ($criterias == array()) {
            return $this->redirectToRoute('motherboard_search');
        }

        //dd($criterias);
        try {
            /** @var MotherboardRepository */
            $moboRepo = $this->getDoctrine()->getRepository(Motherboard::class);
            $data = $moboRepo->findByWithJoin($criterias, array('man1_name' => 'ASC', 'mot0_name' => 'ASC'));
        } catch (Exception $e) {
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

            /** @var MotherboardIdRedirectionRepository */
            $moboIdRedirectionRepo = $this->getDoctrine()->getRepository(MotherboardIdRedirection::class);
            $idRedirection = $moboIdRedirectionRepo->findRedirection($id, 'uh19');

            if (!$idRedirection) {
                throw $this->createNotFoundException(
                    'No $motherboard found for id ' . $id
                );
            } else {
                return $this->redirect($this->generateUrl('motherboard_show', array("id" => $idRedirection)));
            }
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

        $entityManager = $this->getDoctrine()->getManager();

        if (!$motherboard) {
            throw $this->createNotFoundException(
                'No $motherboard found for id ' . $id
            );
        }

        $form = $this->createFormBuilder()
            ->add('No', SubmitType::class)
            ->add('Yes', SubmitType::class)
            ->add('Redirection', NumberType::class, [
                'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('No')->isClicked()) {
                return $this->redirect($this->generateUrl('motherboard_show', array("id" => $id)));
            }
            if ($form->get('Yes')->isClicked()) {
                //If user selected a motherboard where the current id will redirect to
                if ($form->get('Redirection') && !is_null($form->get('Redirection')->getData())) {
                    $idRedirection = $form->get('Redirection')->getData();
                    $destinationMotherboard = $this->getDoctrine()
                        ->getRepository(Motherboard::class)
                        ->find($idRedirection);


                    if ($destinationMotherboard) {
                        //Creating new redirection
                        $redirection = new MotherboardIdRedirection();
                        $redirection->setSource($id);
                        $redirection->setSourceType('uh19');
                        $redirection->setDestination($destinationMotherboard);

                        $entityManager->persist($redirection);

                        //dd($motherboard->getRedirections()->toArray());

                        //Moving each old redirection to the destination motherboard
                        foreach ($motherboard->getRedirections()->toArray() as $redirection) {
                            $newRedirection = new MotherboardIdRedirection();
                            $newRedirection->setSource($redirection->getSource());
                            $newRedirection->setSourceType($redirection->getSourceType());
                            $newRedirection->setDestination($destinationMotherboard);
                            $entityManager->persist($newRedirection);
                        }
                        //dd($destinationMotherboard->getRedirections()->toArray());
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

    /**
     * @Route("/motherboards/search/", name="motherboard_search")
     * @param Request $request
     */
    public function search(Request $request, TranslatorInterface $translator)
    {
        $notIdentifiedMessage = $translator->trans("Not identified");
        /** @var ManufacturerReposiotory */
        $manRepo = $this->getDoctrine()->getRepository(Manufacturer::class);
        $moboManufacturers = $manRepo->findAllMotherboardManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($moboManufacturers, $unidentifiedMan);

        $chipsetManufacturers = $manRepo->findAllChipsetManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($chipsetManufacturers, $unidentifiedMan);

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
        array_unshift($formFactors, $unidentifiedFormFactor);

        $procPlatformTypes = $this->getDoctrine()
            ->getRepository(ProcessorPlatformType::class)
            ->findBy(array(), array('name' => 'ASC'));

        $biosManufacturers = $manRepo->findAllBiosManufacturer();

        $slotsForm = array();
        foreach ($slots as $k => $slotForm) {
            $expSlot = array("expansion_slot" => $slotForm, "count" => 0);
            array_push($slotsForm, $expSlot);
        }
        $portsForm = array();
        foreach ($ports as $k => $portForm) {
            $ioPort = array("io_port" => $portForm, "count" => 0);
            array_push($portsForm, $ioPort);
        }

        $form = $this->createForm(Search::class, array(), [
            'moboManufacturers' => $moboManufacturers,
            'chipsetManufacturers' => $chipsetManufacturers,
            'formFactors' => $formFactors,
            'procPlatformTypes' => $procPlatformTypes,
            'bios' => $biosManufacturers,
            'cpuSockets' => $cpuSockets,
            //'csrf_protection' => false, // that code is aimed to remove cookie requirement but it breaks ajax stuff
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $form->get('searchChipsetManufacturer')->isClicked()
                ||
                $form->get('searchSocket1')->isClicked()
                ||
                $form->get('searchSocket2')->isClicked()
            ) {
                return $this->render('motherboard/search.html.twig', [
                    'form' => $form->createView(),
                    'slots' => $slots,
                    'ports' => $ports,
                ]);
            }

            return $this->redirect($this->generateUrl(
                'mobosearch',
                $this->searchFormToParam($request, $form, $slots, $ports)
            ));
        }
        return $this->render('motherboard/search.html.twig', [
            'form' => $form->createView(),
            'slots' => $slots,
            'ports' => $ports,
        ]);
    }

    private function searchFormToParam(Request $request, $form, $slots, $ports): array
    {
        $parameters = array();
        if ($form['manufacturer']->getData()) {
            if ($form['manufacturer']->getData()->getId() == 0) {
                $parameters['manufacturerId']  = "NULL";
            } else {
                $parameters['manufacturerId'] = $form['manufacturer']->getData()->getId();
            }
        }

        if ($form['searchWithImages']->isClicked()) {
            $parameters['showImages'] = true;
        }

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
                $parameters['chipsetId']  = "NULL";
            } else {
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
        foreach ($slots as $key => $slot) {
            $count = $request->request->get('slot' . $slot->getId());
            if ($count != 0) {
                $sloCount = array('id' => $slot->getId(), 'count' => $count);
                array_push($parameters['expansionSlotsIds'], $sloCount);
            } elseif ($count == '0') {
                $sloCount = array('id' => $slot->getId(), 'count' => null);
                array_push($parameters['expansionSlotsIds'], $sloCount);
            }
        }
        //$parameters['expansionSlotsIds'] = $expansionSlots;

        $ioPorts = array();
        foreach ($ports as $key => $port) {
            $count = $request->request->get('port' . $port->getId());
            if ($count != 0) {
                $porCount = array('id' => $port->getId(), 'count' => $count);
                array_push($ioPorts, $porCount);
            } elseif ($count == '0') {
                $porCount = array('id' => $port->getId(), 'count' => null);
                array_push($ioPorts, $porCount);
            }
        }
        $parameters['ioPortsIds'] = $ioPorts;

        if ($form['chipsetManufacturer']->getData() && !$form['chipset']->getData()) {
            if ($form['chipsetManufacturer']->getData()->getId() == 0) {
                $parameters['chipsetManufacturerId']  = "NULL";
            } else {
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
        /** @var MotherboardRepository */
        $moboRepo = $this->getDoctrine()->getRepository(Motherboard::class);
        $data = $moboRepo->findAllAlphabetic($letter);

        usort(
            $data,
            function ($a, $b) {
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
