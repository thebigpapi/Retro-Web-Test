<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionChip;
use App\Entity\Manufacturer;
use App\Entity\ExpansionChipType;
use App\Form\Admin\Edit\ExpansionChipForm;
use App\Form\Admin\Edit\ExpansionChipTypeForm;
use App\Form\Admin\Manage\ExpansionChipSearchType;
use App\Repository\ExpansionChipRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\ExpansionChipTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ExpansionChipsetController extends AbstractController
{


    /**
     * Routing
     */
    
    #[Route(path: '/admin/manage/expansionchipsets', name: 'admin_manage_expansion_chipsets')]
    public function manage(Request $request)
    {
        switch (htmlentities($request->query->get('entity') ?? '')) {
            case "expansionchip":
                return $this->manageExpansionChips($request);
                break;
            case "expchiptype":
                return $this->manageExpansionChipType($request);
                break;
            default:
                return $this->redirect(
                    $this->generateUrl('admin_manage_expansion_chipsets', array("entity" => "expansionchip"))
                );
        }
    }

    
    #[Route(path: '/admin/manage/expansionchipsets/expansionchips/add', name: 'new_expansionChip_add')]
    public function expansionChipAdd(Request $request, EntityManagerInterface $entityManager, ManufacturerRepository $manufacturerRepository)
    {
        return $this->renderExpansionChipForm($request, new ExpansionChip(), $entityManager, $manufacturerRepository);
    }

    
    #[Route(path: '/admin/manage/expansionchipsets/expansionchips/{id}/edit', name: 'new_expansionChip_edit', requirements: ['id' => '\d+'])]
    public function expansionChipEdit(Request $request, int $id, ExpansionChipRepository $expansionChipRepository, EntityManagerInterface $entityManager, ManufacturerRepository $manufacturerRepository)
    {
        return $this->renderExpansionChipForm(
            $request,
            $expansionChipRepository->find($id),
            $entityManager,
            $manufacturerRepository
        );
    }

    
    #[Route(path: '/admin/manage/expansionchipsets/expchiptypes/add', name: 'new_expansionChipType_add')]
    public function expansionChipTypeAdd(Request $request, EntityManagerInterface $entityManager, ManufacturerRepository $manufacturerRepository)
    {
        return $this->renderExpansionChipTypeForm($request, new ExpansionChipType(), $entityManager, $manufacturerRepository);
    }

    
    #[Route(path: '/admin/manage/expansionchipsets/expchiptypes/{id}/edit', name: 'new_expansionChipType_edit', requirements: ['id' => '\d+'])]
    public function expansionChipTypeEdit(Request $request, int $id, ExpansionChipTypeRepository $expansionChipTypeRepository, EntityManagerInterface $entityManager, ManufacturerRepository $manufacturerRepository)
    {
        return $this->renderExpansionChipTypeForm(
            $request,
            $expansionChipTypeRepository->find($id),
            $entityManager,
            $manufacturerRepository
        );
    }

    /**
     * Index pages
     */

    private function manageExpansionChips(Request $request)
    {
        $search = $this->createForm(ExpansionChipSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) {
                $getParams["manufacturer"] = $data['manufacturer']->getId();
            }
            if ($data['type']) {
                $getParams["type"] = $data['type']->getId();
            }
            $getParams["entity"] = "expansionchip";
            return $this->redirect($this->generateUrl('admin_manage_expansion_chipsets', $getParams));
        } else {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer') ?? '');
            $typeId = htmlentities($request->query->get('type') ?? '');
            if ($manufacturerId && intval($manufacturerId)) {
                $criterias["manufacturer"] = $manufacturerId;
            }
            if ($typeId && intval($typeId)) {
                $criterias["type"] = $typeId;
            }
        }

        return $this->render('admin/manage/expansion_chipsets/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ExpansionChipsetController::listExpansionChip",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => "expansion chip",
            "entityDisplayNamePlural" => "expansion chips",
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageExpansionChipType(Request $request)
    {
        return $this->render('admin/manage/expansion_chipsets/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\ExpansionChipsetController::listExpansionChipType",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => "expansion chip type",
            "entityDisplayNamePlural" => "expansion chip types",
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function listExpansionChip(Request $request, PaginatorInterface $paginator, array $criterias, ExpansionChipRepository $expansionChipRepository)
    {
        $objects = $expansionChipRepository->findBy($criterias);

        usort(
            $objects,
            function ($a, $b) {
                /** @var ExpansionChip $a */
                /** @var ExpansionChip $b */
                $aManufacturer = $a->getManufacturer();
                $bManufacturer = $b->getManufacturer();
                if ($aManufacturer->getShortNameIfExist() == $bManufacturer->getShortNameIfExist()) {
                    if ($a->getName() == $b->getName()) {
                        return 0;
                    }
                    return ($a->getName() < $b->getName()) ? -1 : 1;
                }
                return ($aManufacturer->getShortNameIfExist() < $bManufacturer->getShortNameIfExist()) ? -1 : 1;
            }
        );

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/expansion_chipsets/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function listExpansionChipType(Request $request, PaginatorInterface $paginator, array $criterias, ExpansionChipTypeRepository $expansionChipTypeRepository)
    {
        $objects = $expansionChipTypeRepository->findBy($criterias);

        usort(
            $objects,
            function ($a, $b) {
                /** @var ExpansionChipType $a */
                /** @var ExpansionChipType $b */
                return strnatcasecmp($a->getName(), $b->getName());
            }
        );

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/expansion_chipsets/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    /**
     * Forms
     */

    private function renderExpansionChipForm(Request $request, $chipset, EntityManagerInterface $entityManager, ManufacturerRepository $manufacturerRepository)
    {
        $chipsetManufacturers = $manufacturerRepository->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));

        $form = $this->createForm(ExpansionChipForm::class, $chipset, [
            'chipsetManufacturers' => $chipsetManufacturers,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipset = $form->getData();
            foreach ($form['chip']['pciDevs']->getData() as $key => $val) {
                $val->setChip($chipset);
            }
            foreach ($form['drivers']->getData() as $key => $val) {
                $val->setExpansionChip($chipset);
            }
            $entityManager->persist($chipset);
            $entityManager->flush();

            return $this->redirect(
                $this->generateUrl('admin_manage_expansion_chipsets', array("entity" => "expansionchip"))
            );
        }
        return $this->render('admin/edit/expansion_chipsets/expansionchip.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function renderExpansionChipTypeForm(Request $request, $chipType, EntityManagerInterface $entityManager, ManufacturerRepository $manufacturerRepository)
    {
        $form = $this->createForm(ExpansionChipTypeForm::class, $chipType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipset = $form->getData();

            $entityManager->persist($chipset);
            $entityManager->flush();

            return $this->redirect(
                $this->generateUrl('admin_manage_expansion_chipsets', array("entity" => "expchiptype"))
            );
        }
        return $this->render('admin/edit/expansion_chipsets/expchiptype.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
