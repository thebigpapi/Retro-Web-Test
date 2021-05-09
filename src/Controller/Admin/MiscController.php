<?php
namespace App\Controller\Admin;

use App\Entity\CpuSpeed;
use App\Entity\Creditor;
use App\Entity\KnownIssue;
use App\Entity\Manufacturer;
use App\Form\EditCpuSpeed;
use App\Form\EditCreditor;
use App\Form\EditKnownIssue;
use App\Form\EditManufacturer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class MiscController extends AbstractController {


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/miscs", name="admin_manage_miscs")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)        
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "manufacturer":
                return $this->manage_manufacturers($request, $translator);
                break;
            case "issue":
                return $this->manage_issues($request, $translator);
                break;
            case "freq":
                return $this->manage_freqs($request, $translator);
                break;
            case "creditor":
                return $this->manage_creditors($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_miscs', array("entity" => "manufacturer")));
        }
    }

    /**
     * @Route("/admin/manage/miscs/manufacturers/add", name="new_manufacturer_add")
     * @param Request $request
     */
    public function manufacturerAdd(Request $request)        
    {
        return $this->renderManufacturerForm($request, new Manufacturer(), 'admin/add_manufacturer.html.twig');
    }

    /**
     * @Route("/admin/manage/miscs/manufacturers/{id}/edit", name="new_manufacturer_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function manufacturerEdit(Request $request, int $id)        
    {
        return $this->renderManufacturerForm($request,$this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->find($id)
        , 'admin/add_manufacturer.html.twig');
    }

    /**
     * @Route("/admin/manage/miscs/issues/add", name="new_knownIssue_add")
     * @param Request $request
     */
    public function knownIssueAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new KnownIssue(), EditKnownIssue::class, 'admin/add_knownIssue.html.twig', 'issue');
    }

    /**
     * @Route("/admin/manage/miscs/issues/{id}/edit", name="new_knownIssue_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function knownIssueEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
        ->getRepository(KnownIssue::class)
        ->find($id)
        , EditKnownIssue::class, 'admin/add_knownIssue.html.twig', 'issue');
    }

    /**
     * @Route("/admin/manage/miscs/freqs/add", name="new_cpuSpeed_add")
     * @param Request $request
     */
    public function cpuSpeedAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new CpuSpeed(), EditCpuSpeed::class, 'admin/add_cpuSpeed.html.twig', 'freq');
    }

    /**
     * @Route("/admin/manage/miscs/freqs/{id}/edit", name="new_cpuSpeed_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function cpuSpeedEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
        ->getRepository(CpuSpeed::class)
        ->find($id)
        , EditCpuSpeed::class, 'admin/add_cpuSpeed.html.twig', 'freq');
    }

    /**
     * @Route("/admin/manage/miscs/creditors/add", name="new_creditor_add")
     * @param Request $request
     */
    public function creditorAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new Creditor(), EditCreditor::class, 'admin/add_creditor.html.twig', 'creditor');
    }

    /**
     * @Route("/admin/manage/miscs/creditors/{id}/edit", name="new_creditor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function creditorEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
        ->getRepository(Creditor::class)
        ->find($id)
        , EditCreditor::class, 'admin/add_creditor.html.twig', 'creditor');
    }

    /**
     * Index pages
     */

    private function manage_manufacturers(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/miscs/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MiscController::list_manufacturer",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("manufacturer"),
            "entityDisplayNamePlural" => $translator->trans("manufacturers"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_issues(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/miscs/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MiscController::list_issue",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("known issue"),
            "entityDisplayNamePlural" => $translator->trans("known issues"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_freqs(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/miscs/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MiscController::list_freq",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("frequency"),
            "entityDisplayNamePlural" => $translator->trans("frequencies"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_creditors(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/miscs/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MiscController::list_creditor",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("creditor"),
            "entityDisplayNamePlural" => $translator->trans("creditors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function list_manufacturer(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(Manufacturer::class)
            ->findBy($criterias, ['name' => 'asc']);

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

    public function list_issue(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(KnownIssue::class)
            ->findBy($criterias);

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

    public function list_freq(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(CpuSpeed::class)
            ->findBy($criterias, ['value' => 'asc']);

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

    public function list_creditor(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(Creditor::class)
            ->findBy($criterias, ['name' => 'asc']);

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

    private function renderManufacturerForm(Request $request, Manufacturer $entity, $template)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(EditManufacturer::class, $entity);
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

    private function renderEntityForm(Request $request, $entity, $class, $template, $entityName) {
        $entityManager = $this->getDoctrine()->getManager();
        
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