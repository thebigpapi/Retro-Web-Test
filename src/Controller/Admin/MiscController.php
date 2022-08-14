<?php

namespace App\Controller\Admin;

use App\Entity\CpuSpeed;
use App\Entity\Creditor;
use App\Entity\KnownIssue;
use App\Entity\Manufacturer;
use App\Form\Admin\Edit\CpuSpeedForm;
use App\Form\Admin\Edit\CreditorForm;
use App\Form\Admin\Edit\KnownIssueForm;
use App\Form\Admin\Edit\ManufacturerForm;
use App\Repository\CpuSpeedRepository;
use App\Repository\CreditorRepository;
use App\Repository\KnownIssueRepository;
use App\Repository\ManufacturerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class MiscController extends AbstractController
{


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/miscs", name="admin_manage_miscs")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)
    {
        switch (htmlentities($request->query->get('entity') ?? '')) {
            case "manufacturer":
                return $this->manageManufacturers($request, $translator);
                break;
            case "issue":
                return $this->manageIssues($request, $translator);
                break;
            case "freq":
                return $this->manageFreqs($request, $translator);
                break;
            case "creditor":
                return $this->manageCreditors($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_miscs', array("entity" => "manufacturer")));
        }
    }

    /**
     * @Route("/admin/manage/miscs/manufacturers/add", name="new_manufacturer_add")
     * @param Request $request
     */
    public function manufacturerAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderManufacturerForm($request, new Manufacturer(), 'admin/edit/miscs/manufacturer.html.twig', $entityManager);
    }

    /**
     * @Route("/admin/manage/miscs/manufacturers/{id}/edit", name="new_manufacturer_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function manufacturerEdit(Request $request, int $id, ManufacturerRepository $manufacturerRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderManufacturerForm(
            $request,
            $manufacturerRepository->find($id),
            'admin/edit/miscs/manufacturer.html.twig',
            $entityManager
        );
    }

    /**
     * @Route("/admin/manage/miscs/issues/add", name="new_knownIssue_add")
     * @param Request $request
     */
    public function knownIssueAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            new KnownIssue(),
            KnownIssueForm::class,
            'admin/edit/miscs/knownIssue.html.twig',
            'issue',
            $entityManager
        );
    }

    /**
     * @Route("/admin/manage/miscs/issues/{id}/edit", name="new_knownIssue_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function knownIssueEdit(Request $request, int $id, KnownIssueRepository $knownIssueRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            $knownIssueRepository->find($id),
            KnownIssueForm::class,
            'admin/edit/miscs/knownIssue.html.twig',
            'issue',
            $entityManager
        );
    }

    /**
     * @Route("/admin/manage/miscs/freqs/add", name="new_cpuSpeed_add")
     * @param Request $request
     */
    public function cpuSpeedAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            new CpuSpeed(),
            CpuSpeedForm::class,
            'admin/edit/miscs/cpuSpeed.html.twig',
            'freq',
            $entityManager
        );
    }

    /**
     * @Route("/admin/manage/miscs/freqs/{id}/edit", name="new_cpuSpeed_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function cpuSpeedEdit(Request $request, int $id, CpuSpeedRepository $cpuSpeedRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            $cpuSpeedRepository->find($id),
            CpuSpeedForm::class,
            'admin/edit/miscs/cpuSpeed.html.twig',
            'freq',
            $entityManager
        );
    }

    /**
     * @Route("/admin/manage/miscs/creditors/add", name="new_creditor_add")
     * @param Request $request
     */
    public function creditorAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            new Creditor(),
            CreditorForm::class,
            'admin/edit/miscs/creditor.html.twig',
            'creditor',
            $entityManager
        );
    }

    /**
     * @Route("/admin/manage/miscs/creditors/{id}/edit", name="new_creditor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function creditorEdit(Request $request, int $id, CreditorRepository $creditorRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            $creditorRepository->find($id),
            CreditorForm::class,
            'admin/edit/miscs/creditor.html.twig',
            'creditor',
            $entityManager
        );
    }

    /**
     * Index pages
     */

    private function manageManufacturers(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/miscs/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MiscController::listManufacturer",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("manufacturer"),
            "entityDisplayNamePlural" => $translator->trans("manufacturers"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageIssues(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/miscs/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MiscController::listIssue",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("known issue"),
            "entityDisplayNamePlural" => $translator->trans("known issues"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageFreqs(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/miscs/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MiscController::listFreq",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("frequency"),
            "entityDisplayNamePlural" => $translator->trans("frequencies"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageCreditors(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/miscs/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MiscController::listCreditor",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("creditor"),
            "entityDisplayNamePlural" => $translator->trans("creditors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function listManufacturer(Request $request, PaginatorInterface $paginator, array $criterias, ManufacturerRepository $manufacturerRepository)
    {
        $objects = $manufacturerRepository->findBy($criterias, ['name' => 'asc']);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/miscs/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function listIssue(Request $request, PaginatorInterface $paginator, array $criterias, KnownIssueRepository $knownIssueRepository)
    {
        $objects = $knownIssueRepository->findBy($criterias);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/miscs/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function listFreq(Request $request, PaginatorInterface $paginator, array $criterias, CpuSpeedRepository $cpuSpeedRepository)
    {
        $objects = $cpuSpeedRepository->findBy($criterias, ['value' => 'asc']);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/miscs/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function listCreditor(Request $request, PaginatorInterface $paginator, array $criterias, CreditorRepository $creditorRepository)
    {
        $objects = $creditorRepository->findBy($criterias, ['name' => 'asc']);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/miscs/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    /**
     * Forms
     */

    private function renderManufacturerForm(Request $request, Manufacturer $entity, $template, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ManufacturerForm::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            foreach ($form['biosCodes']->getData() as $key => $val) {
                $val->setManufacturer($entity);
            }

            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->redirectToRoute('admin_manage_miscs', array('entity' => 'manufacturer'));
        }
        return $this->render($template, [
            'form' => $form->createView(),
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

            return $this->redirect($this->generateUrl('admin_manage_miscs', array("entity" => $entityName)));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }
}
