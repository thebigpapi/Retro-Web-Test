<?php

namespace App\Controller\Admin;

use App\Entity\Chipset;
use App\Entity\CpuSocket;
use App\Entity\FormFactor;
use App\Entity\Motherboard;
use App\Entity\Processor;
use App\Entity\ProcessorPlatformType;
use App\Form\Admin\Manage\MotherboardSearchType;
use App\Form\Admin\Edit\FormFactorForm;
use App\Form\Admin\Edit\MotherboardForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Repository\ChipsetRepository;
use App\Repository\CpuSocketRepository;
use App\Repository\FormFactorRepository;
use App\Repository\MotherboardRepository;
use Doctrine\ORM\EntityManager;

class MotherboardController extends AbstractController
{


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/motherboards", name="admin_manage_motherboards")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "motherboard":
                return $this->manageMotherboards($request, $translator);
                break;
            case "formfactor":
                return $this->manageFormfactors($request, $translator);
                break;
            default:
                return $this->redirect(
                    $this->generateUrl(
                        'admin_manage_motherboards',
                        array("entity" => "motherboard")
                    )
                );
        }
    }

    /**
     * @Route("/admin/manage/motherboards/motherboards/add", name="new_motherboard_add")
     * @param Request $request
     */
    public function motherboardAdd(Request $request, ChipsetRepository $chipsetRepository, CpuSocketRepository $cpuSocketRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderMotherboardForm(
            $request,
            new Motherboard(), 
            $chipsetRepository, 
            $cpuSocketRepository, 
            $entityManager
        );
    }

    /**
     * @Route(
     *   "/admin/manage/motherboards/motherboards/{id}/edit",
     *    name="new_motherboard_edit",
     *    requirements={"id"="\d+"})
     * @param Request $request
     */
    public function motherboardEdit(Request $request, MotherboardRepository $motherboardRepository, int $id, ChipsetRepository $chipsetRepository, CpuSocketRepository $cpuSocketRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderMotherboardForm(
            $request,
            $motherboardRepository->find($id),
            $chipsetRepository, 
            $cpuSocketRepository, 
            $entityManager
        );
    }

    /**
     * @Route("/admin/manage/motherboards/formfactors/add", name="new_formFactor_add")
     * @param Request $request
     */
    public function formFactorAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            new FormFactor(),
            FormFactorForm::class,
            'admin/edit/motherboards/formFactor.html.twig',
            'formfactor',
            $entityManager
        );
    }

    /**
     * @Route("/admin/manage/motherboards/formfactors/{id}/edit", name="new_formFactor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function formFactorEdit(Request $request, int $id, FormFactorRepository $formFactorRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            $formFactorRepository->find($id),
            FormFactorForm::class,
            'admin/edit/motherboards/formFactor.html.twig',
            'formfactor',
            $entityManager
        );
    }

    /**
     * Index pages
     */

    private function manageMotherboards(Request $request, TranslatorInterface $translator)
    {
        /*$search = $this->createForm(MotherboardSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) {
                $getParams["manufacturer"] = $data['manufacturer']->getId();
            }
            if ($data['formFactor']) {
                $getParams["formFactor"] = $data['formFactor']->getId();
            }
            if ($data['name']) {
                $getParams["name"] = $data['name'];
            }
            if ($data['chipset'])
                $getParams["chipset"] = $data['chipset']->getId(); 
            $getParams["entity"] = "motherboard";
            //dd($getParams);
            return $this->redirect($this->generateUrl('admin_manage_motherboards', $getParams));
        } else {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer'));
            if ($manufacturerId && intval($manufacturerId)) {
                $criterias["manufacturer"] = $manufacturerId;
            }
            $formFactorId = htmlentities($request->query->get('formFactor'));
            if ($formFactorId && intval($formFactorId)) {
                $criterias["formFactor"] = $formFactorId;
            }
            $name = htmlentities($request->query->get('name'));
            if ($name) {
                $criterias["name"] = "$name";
            }
            $chipsetId = htmlentities($request->query->get('chipset'));
            if ($chipsetId && intval($chipsetId)) {
                $criterias["chipset"] = $chipsetId;
            }
        }
        /*if($criterias)*/
        //dd($request->query->get('entity'));
        return $this->render('admin/manage/motherboards/manage.html.twig', [
            /*"search" => $search->createView(),
            "criterias" => $criterias,*/
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MotherboardController::listMotherboard",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("motherboard"),
            "entityDisplayNamePlural" => $translator->trans("motherboards"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageFormfactors(Request $request, TranslatorInterface $translator)
    {

        return $this->render('admin/manage/motherboards/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MotherboardController::listFormfactor",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("form factor"),
            "entityDisplayNamePlural" => $translator->trans("form factors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    /*public function listMotherboard(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator, /*array $criterias*) {
        /*$where = "";
        if (!empty($criterias) && array_key_exists("manufacturer", $criterias)) {
            $where = "WHERE m.manufacturer = :manufacturer";
        }

        $dql   = "SELECT m FROM App:Motherboard m JOIN m.manufacturer n $where ORDER BY m.lastEdited DESC";
        $query = $em->createQuery($dql);
        $query->setParameters($criterias);*
        $mobos = $this->getDoctrine()
            ->getRepository(Motherboard::class);
            //->findBy($criterias);
        usort(
            $mobos,
            function ($a, $b) {
                if ($a->getLastEdited() == $b->getLastEdited()) {
                    return 0;
                }
                return ($a->getLastEdited() > $b->getLastEdited()) ? -1 : 1;
            }
        );
        //$mobos = Motherboard::sort(new ArrayCollection($mobos));
        $paginatedObjects = $paginator->paginate(
            $mobos,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/motherboards/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }*/
    public function listMotherboard(
        EntityManagerInterface $em,
        Request $request,
        PaginatorInterface $paginator,
        array $criterias
    ) {

        $dql   = "SELECT m FROM App:Motherboard m ORDER BY m.lastEdited DESC";
        $query = $em->createQuery($dql);

        $paginatedObjects = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/motherboards/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }
    public function listFormfactor(Request $request, PaginatorInterface $paginator, array $criterias)
    {
        $objects = $this->getDoctrine()
            ->getRepository(FormFactor::class)
            ->findBy($criterias, ["name" => "ASC"]);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/motherboards/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    /**
     * Forms
     */

    private function renderMotherboardForm(Request $request, Motherboard $mobo, ChipsetRepository $chipsetRepository, CpuSocketRepository $cpuSocketRepository, EntityManagerInterface $entityManager)
    {
        /**
         * @var array<Chipset>
         */
        $chipsets = $chipsetRepository->findAllChipsetManufacturer();

        usort(
            $chipsets,
            function ($a, $b) {
                if ($a->getMainChipWithManufacturer() == $b->getMainChipWithManufacturer()) {
                    return 0;
                }
                return ($a->getMainChipWithManufacturer() < $b->getMainChipWithManufacturer()) ? -1 : 1;
            }
        );

        $sockets = $cpuSocketRepository->findBy(array(), array('name' => 'ASC'));


        $form = $this->createForm(MotherboardForm::class, $mobo, [
            'chipsets' => $chipsets,
            'sockets' => $sockets,
        ]);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('updateProcessors')->isClicked()) {
                return $this->render('admin/edit/motherboards/motherboard.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            $mobo = $form->getData();
            $mobo->updateLastEdited();
            foreach ($form['motherboardAliases']->getData() as $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['motherboardIoPorts']->getData() as $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['motherboardExpansionSlots']->getData() as $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['manuals']->getData() as $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['motherboardBios']->getData() as $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['images']->getData() as $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['motherboardMaxRams']->getData() as $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['drivers']->getData() as $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['redirections']->getData() as $val) {
                $val->setDestination($mobo);
            }
            if ($mobo->getManufacturer() != null && $mobo->getManufacturer()->getId() == 0) {
                $mobo->setManufacturer(null);
            }
            
            $entityManager->persist($mobo);

            $entityManager->flush();

            return $this->redirectToRoute('motherboard_show', array('id' => $mobo->getId()));
        }
        return $this->render('admin/edit/motherboards/motherboard.html.twig', [
            'form' => $form->createView(),
            'moboid' =>$mobo->getId(),
        ]);
    }

    private function renderEntityForm(Request $request, $entity, $class, $template, $entityName, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm($class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('admin_manage_motherboards', array("entity" => $entityName)));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }
}
