<?php

namespace App\Controller\Admin;

use App\Entity\Chipset;
use App\Entity\CpuSocket;
use App\Entity\FormFactor;
use App\Entity\Motherboard;
use App\Entity\Processor;
use App\Entity\ProcessorPlatformType;
use App\Form\Admin\Edit\FormFactorForm;
use App\Form\Admin\Edit\MotherboardForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Repository\ChipsetRepository;

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
    public function motherboardAdd(Request $request)
    {
        return $this->renderMotherboardForm($request, new Motherboard());
    }

    /**
     * @Route(
     *   "/admin/manage/motherboards/motherboards/{id}/edit",
     *    name="new_motherboard_edit",
     *    requirements={"id"="\d+"})
     * @param Request $request
     */
    public function motherboardEdit(Request $request, int $id)
    {
        return $this->renderMotherboardForm(
            $request,
            $this->getDoctrine()
                ->getRepository(Motherboard::class)
                ->find($id)
        );
    }

    /**
     * @Route("/admin/manage/motherboards/formfactors/add", name="new_formFactor_add")
     * @param Request $request
     */
    public function formFactorAdd(Request $request)
    {
        return $this->renderEntityForm(
            $request,
            new FormFactor(),
            FormFactorForm::class,
            'admin/edit/motherboards/formFactor.html.twig',
            'formfactor'
        );
    }

    /**
     * @Route("/admin/manage/motherboards/formfactors/{id}/edit", name="new_formFactor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function formFactorEdit(Request $request, int $id)
    {
        return $this->renderEntityForm(
            $request,
            $this->getDoctrine()
                ->getRepository(FormFactor::class)
                ->find($id),
            FormFactorForm::class,
            'admin/edit/motherboards/formFactor.html.twig',
            'formfactor'
        );
    }

    /**
     * Index pages
     */

    private function manageMotherboards(Request $request, TranslatorInterface $translator)
    {

        return $this->render('admin/manage/motherboards/manage.html.twig', [
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

    public function listMotherboard(
        EntityManagerInterface $em,
        Request $request,
        PaginatorInterface $paginator,
        array $criterias
    ) {
        /*$objects = $this->getDoctrine()
            ->getRepository(Motherboard::class)
            ->findBy($criterias, ["lastEdited" => "DESC"]);*/

        //$this->createQueryBuilder();

        /*$paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );*/

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

    private function renderMotherboardForm(Request $request, Motherboard $mobo)
    {
        $entityManager = $this->getDoctrine()->getManager();

        /** @var ChipsetRepository */
        $chipsetRepo = $this->getDoctrine()->getRepository(Chipset::class);
        $chipsets = $chipsetRepo->findAllChipsetManufacturer();

        usort(
            $chipsets,
            function ($a, $b) {
                if ($a->getMainChipWithManufacturer() == $b->getMainChipWithManufacturer()) {
                    return 0;
                }
                return ($a->getMainChipWithManufacturer() < $b->getMainChipWithManufacturer()) ? -1 : 1;
            }
        );

        $cpus = $this->getDoctrine()
            ->getRepository(Processor::class)
            ->findAll();

        usort(
            $cpus,
            function ($a, $b) {
                if ($a->getNameWithPlatform() == $b->getNameWithPlatform()) {
                    return 0;
                }
                return ($a->getNameWithPlatform() < $b->getNameWithPlatform()) ? -1 : 1;
            }
        );

        $procPlatformTypes = $this->getDoctrine()
            ->getRepository(ProcessorPlatformType::class)
            ->findBy(array(), array('name' => 'ASC'));

        $sockets = $this->getDoctrine()
            ->getRepository(CpuSocket::class)
            ->findBy(array(), array('name' => 'ASC'));


        $form = $this->createForm(MotherboardForm::class, $mobo, [
            'chipsets' => $chipsets,
            'cpus' => $cpus,
            'procPlatformTypes' => $procPlatformTypes,
            'sockets' => $sockets,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('updateProcessors')->isClicked()) {
                return $this->render('motherboard/add.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
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
            foreach ($form['drivers']->getData() as $key => $val) {
                $val->setMotherboard($mobo);
            }
            foreach ($form['redirections']->getData() as $key => $val) {
                $val->setDestination($mobo);
            }
            if ($mobo->getManufacturer() != null && $mobo->getManufacturer()->getId() == 0) {
                $mobo->setManufacturer(null);
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

    private function renderEntityForm(Request $request, $entity, $class, $template, $entityName)
    {
        $entityManager = $this->getDoctrine()->getManager();

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
