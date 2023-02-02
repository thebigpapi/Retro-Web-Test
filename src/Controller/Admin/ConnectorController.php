<?php

namespace App\Controller\Admin;

use App\Entity\CpuSocket;
use App\Entity\ExpansionSlot;
use App\Entity\IoPort;
use App\Entity\PSUConnector;
use App\Form\Admin\Edit\CpuSocketForm;
use App\Form\Admin\Edit\ExpansionSlotForm;
use App\Form\Admin\Edit\IoPortForm;
use App\Form\Admin\Edit\PsuConnectorForm;
use App\Repository\CpuSocketRepository;
use App\Repository\CpuSpeedRepository;
use App\Repository\ExpansionSlotRepository;
use App\Repository\IoPortRepository;
use App\Repository\PSUConnectorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ConnectorController extends AbstractController
{
    /**
     * Routing
     */

    #[Route(path: '/admin/manage/connectors', name: 'admin_manage_connectors')]
    public function manage(Request $request, TranslatorInterface $translator)
    {
        switch (htmlentities($request->query->get('entity') ?? '')) {
            case "expansion":
                return $this->manageExpansion($request, $translator);
                break;
            case "io":
                return $this->manageIo($request, $translator);
                break;
            case "socket":
                return $this->manageSocket($request, $translator);
                break;
            case "psuconnector":
                return $this->managePsuConnector($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_connectors', array("entity" => "expansion")));
        }
    }


    #[Route(path: '/admin/manage/connectors/expansions/add', name: 'new_expansionSlot_add')]
    public function expansionSlotAdd(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        return $this->renderEntityForm(
            $request,
            new ExpansionSlot(),
            ExpansionSlotForm::class,
            'admin/edit/connectors/expansionSlot.html.twig',
            'expansion',
            $entityManagerInterface
        );
    }


    #[Route(path: '/admin/manage/connectors/expansions/{id}/edit', name: 'new_expansionSlot_edit', requirements: ['id' => '\d+'])]
    public function expansionSlotEdit(Request $request, int $id, ExpansionSlotRepository $expansionSlotRepository, EntityManagerInterface $entityManagerInterface)
    {
        return $this->renderEntityForm(
            $request,
            $expansionSlotRepository->find($id),
            ExpansionSlotForm::class,
            'admin/edit/connectors/expansionSlot.html.twig',
            'expansion',
            $entityManagerInterface
        );
    }


    #[Route(path: '/admin/manage/connectors/ios/add', name: 'new_ioPort_add')]
    public function ioPortAdd(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        return $this->renderEntityForm(
            $request,
            new IoPort(),
            IoPortForm::class,
            'admin/edit/connectors/ioPort.html.twig',
            'io',
            $entityManagerInterface
        );
    }


    #[Route(path: '/admin/manage/connectors/ios/{id}/edit', name: 'new_ioPort_edit', requirements: ['id' => '\d+'])]
    public function ioPortEdit(Request $request, int $id, IoPortRepository $ioPortRepository, EntityManagerInterface $entityManagerInterface)
    {
        return $this->renderEntityForm(
            $request,
            $ioPortRepository->find($id),
            IoPortForm::class,
            'admin/edit/connectors/ioPort.html.twig',
            'io',
            $entityManagerInterface
        );
    }


    #[Route(path: '/admin/manage/connectors/sockets/add', name: 'new_cpuSocket_add')]
    public function cpuSocketAdd(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        return $this->renderEntityForm(
            $request,
            new CpuSocket(),
            CpuSocketForm::class,
            'admin/edit/connectors/cpuSocket.html.twig',
            'socket',
            $entityManagerInterface
        );
    }


    #[Route(path: '/admin/manage/connectors/sockets/{id}/edit', name: 'new_cpuSocket_edit', requirements: ['id' => '\d+'])]
    public function cpuSocketEdit(Request $request, int $id, CpuSocketRepository $cpuSocketRepository, EntityManagerInterface $entityManagerInterface)
    {
        return $this->renderEntityForm(
            $request,
            $cpuSocketRepository->find($id),
            CpuSocketForm::class,
            'admin/edit/connectors/cpuSocket.html.twig',
            'socket',
            $entityManagerInterface
        );
    }



    #[Route(path: '/admin/manage/connectors/psuconnectors/add', name: 'new_psu_add')]
    public function psuConnectorAdd(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        return $this->renderEntityForm(
            $request,
            new PSUConnector(),
            PSUConnectorForm::class,
            'admin/edit/connectors/psuconnector.html.twig',
            'psuconnector',
            $entityManagerInterface
        );
    }

    #[Route(path: '/admin/manage/connectors/psuconnectors/{id}/edit', name: 'new_psu_edit', requirements: ['id' => '\d+'])]
    public function psuConnectorEdit(Request $request, int $id, PSUConnectorRepository $pSUConnectorRepository, EntityManagerInterface $entityManagerInterface)
    {
        return $this->renderEntityForm(
            $request,
            $pSUConnectorRepository->find($id),
            PsuConnectorForm::class,
            'admin/edit/connectors/psuconnector.html.twig',
            'psuconnector',
            $entityManagerInterface
        );
    }

    /**
     * Index pages
     */

    private function manageExpansion(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/connectors/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\ConnectorController::listExpansion",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("expansion slot"),
            "entityDisplayNamePlural" => $translator->trans("expansion slots"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageIo(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/connectors/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\ConnectorController::listIo",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("i/o connector"),
            "entityDisplayNamePlural" => $translator->trans("i/o connectors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageSocket(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/connectors/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\ConnectorController::listSocket",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("socket"),
            "entityDisplayNamePlural" => $translator->trans("sockets"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function managePsuConnector(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/connectors/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\ConnectorController::listPsuConnector",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("psu connector"),
            "entityDisplayNamePlural" => $translator->trans("psu connectors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function listExpansion(Request $request, PaginatorInterface $paginator, array $criterias, ExpansionSlotRepository $expansionSlotRepository)
    {
        $objects = $expansionSlotRepository->findBy($criterias);


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

    public function listIo(Request $request, PaginatorInterface $paginator, array $criterias, IoPortRepository $ioPortRepository)
    {
        $objects = $ioPortRepository->findBy($criterias);

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

    public function listSocket(Request $request, PaginatorInterface $paginator, array $criterias, CpuSocketRepository $cpuSocketRepository)
    {
        $objects = $cpuSocketRepository->findBy($criterias, ['type' => 'asc']);

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

    public function listPsuConnector(Request $request, PaginatorInterface $paginator, array $criterias, PSUConnectorRepository $pSUConnectorRepository)
    {
        $objects = $pSUConnectorRepository->findBy($criterias, ['name' => 'asc']);


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
    private function renderEntityForm(Request $request, $entity, $class, $template, $entityName, EntityManagerInterface $entityManager)
    {
        //dd($entity);
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
