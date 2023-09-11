<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Entity\FormFactor;
use App\Entity\Motherboard;
use App\Entity\MotherboardIdRedirection;
use App\Form\Motherboard\Search;
use App\Repository\CpuSocketRepository;
use App\Repository\ExpansionSlotRepository;
use App\Repository\FormFactorRepository;
use App\Repository\IoPortRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\MotherboardIdRedirectionRepository;
use App\Repository\MotherboardRepository;
use App\Repository\ProcessorPlatformTypeRepository;
use App\Repository\ExpansionChipRepository;
use App\Repository\ExpansionChipTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Exception;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class MotherboardController extends AbstractController
{
    public function addCriteriaById(Request $request, array &$criterias, string $htmlId, string $sqlId): void
    {
        $entityId = htmlentities($request->query->get($htmlId) ?? '');
        if ($entityId && intval($entityId)) $criterias[$sqlId] = "$entityId";
        elseif ($entityId === "NULL") $criterias[$sqlId] = null;
    }
    public function addArrayCriteria(Request $request, array &$criterias, string $htmlId, string $sqlId): void
    {
        $entityIds = $request->query->get($htmlId);
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
    #[Route('/motherboards/', name: 'mobosearch', methods: ['GET'])]
    public function searchResult(
        Request $request,
        PaginatorInterface $paginator,
        MotherboardRepository $motherboardRepository
    ): Response {
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

        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));

        if ($criterias == array()) {
            return $this->redirectToRoute('motherboard_search');
        }

        $data = $motherboardRepository->findByWithJoin($criterias, array('man1_name' => 'ASC', 'mot0_name' => 'ASC'));
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

    #[Route('/motherboards/{id}/delete/', name: 'motherboard_delete', requirements: ["id" => "\d+"])]
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

    #[Route('/motherboards/search/', name: 'motherboard_search')]
    public function search(
        Request $request,
        TranslatorInterface $translator,
        ManufacturerRepository $manufacturerRepository,
        ExpansionSlotRepository $expansionSlotRepository,
        IoPortRepository $ioPortRepository,
        CpuSocketRepository $cpuSocketRepository,
        FormFactorRepository $formFactorRepository,
        ProcessorPlatformTypeRepository $processorPlatformTypeRepository
    ): Response {
        $notIdentifiedMessage = $translator->trans("Not identified");
        $moboManufacturers = $manufacturerRepository->findAllMotherboardManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($moboManufacturers, $unidentifiedMan);

        $chipsetManufacturers = $manufacturerRepository->findAllChipsetManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($chipsetManufacturers, $unidentifiedMan);

        $slots = $expansionSlotRepository->findAll();

        $ports = $ioPortRepository->findAll();

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
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('mobosearch', $this->searchFormToParam($request, $form)));
        }
        return $this->render('motherboard/search.html.twig', [
            'form' => $form->createView(),
        ]);
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

        /**
         * @var ClickableInterface
         */
        $searchWithImagesButton = $form['searchWithImages'];

        if ($searchWithImagesButton->isClicked()) {
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

        $slots = $form['motherboardExpansionSlots']->getData();
        if ($slots) {
            $parameters['expansionSlotsIds'] = array();
            foreach ($slots as $slot) {
                $count = $slot->getCount();
                if ((int)$count !== 0) {
                    $slotCount = array('id' => $slot->getExpansionSlot()->getId(), 'count' => (int)$count);
                    array_push($parameters['expansionSlotsIds'], $slotCount);
                } elseif ($count === '0') {
                    $slotCount = array('id' => $slot->getExpansionSlot()->getId(), 'count' => null);
                    array_push($parameters['expansionSlotsIds'], $slotCount);
                }
            }
        }

        $ports = $form['motherboardIoPorts']->getData();
        if ($ports) {
            $parameters['ioPortsIds'] = array();
            foreach ($ports as $port) {
                $count = $port->getCount();
                if ((int)$count && $count !== 0) {
                    $portCount = array('id' => $port->getIoPort()->getId(), 'count' => (int)$count);
                    array_push($parameters['ioPortsIds'], $portCount);
                } elseif ($count === '0') {
                    $portCount = array('id' => $port->getIoPort()->getId(), 'count' => null);
                    array_push($parameters['ioPortsIds'], $portCount);
                }
            }
        }

        if ($form['chipsetManufacturer']->getData() && !$form['chipset']->getData()) {
            if ($form['chipsetManufacturer']->getData()->getId() == 0) {
                $parameters['chipsetManufacturerId']  = "NULL";
            } else {
                $parameters['chipsetManufacturerId'] = $form['chipsetManufacturer']->getData()->getId();
            }
        }

        return $parameters;
    }

    #[Route('/motherboards/index/{letter}', name: "moboindex", requirements: ['letter' => '\w|[?]'], methods: ['GET'])]
    public function index(
        PaginatorInterface $paginator,
        string $letter,
        MotherboardRepository $motherboardRepository,
        Request $request
    ): Response {
        $letter === "?" ? $letter = "" : "";
        $data = $motherboardRepository->findAllAlphabetic($letter);

        $motherboards = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('motherboard/index.html.twig', [
            'motherboards' => $motherboards,
            'letter' => $letter,
        ]);
    }
}
