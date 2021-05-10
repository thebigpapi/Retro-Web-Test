<?php
namespace App\Controller\Admin;

use App\Entity\CpuSocket;
use App\Entity\ExpansionSlot;
use App\Entity\IoPort;
use App\Form\Admin\Edit\CpuSocketForm;
use App\Form\Admin\Edit\ExpansionSlotForm;
use App\Form\Admin\Edit\IoPortForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ConnectorController extends AbstractController {


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/connectors", name="admin_manage_connectors")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)        
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "expansion":
                return $this->manage_expansion($request, $translator);
                break;
            case "io":
                return $this->manage_io($request, $translator);
                break;
            case "socket":
                return $this->manage_socket($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_connectors', array("entity" => "expansion")));
        }
    }

    /**
     * @Route("/admin/manage/connectors/expansions/add", name="new_expansionSlot_add")
     * @param Request $request
     */
    public function expansionSlotAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new ExpansionSlot(), ExpansionSlotForm::class, 'admin/add_expansionSlot.html.twig', 'expansion');
    }

    /**
     * @Route("/admin/manage/connectors/expansions/{id}/edit", name="new_expansionSlot_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function expansionSlotEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
        ->getRepository(ExpansionSlot::class)
        ->find($id)
        , ExpansionSlotForm::class, 'admin/add_expansionSlot.html.twig', 'expansion');
    }

    /**
     * @Route("/admin/manage/connectors/ios/add", name="new_ioPort_add")
     * @param Request $request
     */
    public function ioPortAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new IoPort(), IoPortForm::class, 'admin/add_ioPort.html.twig', 'io');
    }

    /**
     * @Route("/admin/manage/connectors/ios/{id}/edit", name="new_ioPort_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function ioPortEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
        ->getRepository(IoPort::class)
        ->find($id)
        , IoPortForm::class, 'admin/add_ioPort.html.twig', 'io');
    }

    /**
     * @Route("/admin/manage/connectors/sockets/add", name="new_cpuSocket_add")
     * @param Request $request
     */
    public function cpuSocketAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new CpuSocket(), CpuSocketForm::class, 'admin/add_cpuSocket.html.twig', 'socket');
    }

    /**
     * @Route("/admin/manage/connectors/sockets/{id}/edit", name="new_cpuSocket_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function cpuSocketEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request, $this->getDoctrine()
        ->getRepository(CpuSocket::class)
        ->find($id)
        , CpuSocketForm::class, 'admin/add_cpuSocket.html.twig', 'socket');
    }

    /**
     * Index pages
     */

    private function manage_expansion(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/connectors/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\ConnectorController::list_expansion",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("expansion slot"),
            "entityDisplayNamePlural" => $translator->trans("expansion slots"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_io(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/connectors/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\ConnectorController::list_io",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("i/o connector"),
            "entityDisplayNamePlural" => $translator->trans("i/o connectors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_socket(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/connectors/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\ConnectorController::list_socket",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("socket"),
            "entityDisplayNamePlural" => $translator->trans("sockets"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function list_expansion(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(ExpansionSlot::class)
            ->findBy($criterias);
        

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/connectors/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function list_io(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(IoPort::class)
            ->findBy($criterias);
        

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/connectors/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function list_socket(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(CpuSocket::class)
            ->findBy($criterias, ['type' => 'asc']);
        

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/connectors/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    /**
     * Forms
     */
    private function renderEntityForm(Request $request, $entity, $class, $template, $entityName) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm($class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            
            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('admin_manage_connectors', array("entity" => $entityName)));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

}