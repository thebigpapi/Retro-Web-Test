<?php

namespace App\Controller\Admin;

use App\Entity\Coprocessor;
use App\Entity\InstructionSet;
use App\Entity\Processor;
use App\Entity\ProcessorPlatformType;
use App\Form\Admin\Edit\CoprocessorForm;
use App\Form\Admin\Edit\InstructionSetForm;
use App\Form\Admin\Edit\ProcessorForm;
use App\Form\Admin\Edit\ProcessorPlatformTypeFormForm;
use App\Form\Admin\Manage\ProcessorSearchType;
use App\Repository\CoprocessorRepository;
use App\Repository\InstructionSetRepository;
use App\Repository\ProcessorPlatformTypeRepository;
use App\Repository\ProcessorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProcessingUnitController extends AbstractController
{
    /**
     * Routing
     */

    #[Route(path: '/admin/manage/processingunits', name: 'admin_manage_processing_units')]
    public function manage(Request $request, TranslatorInterface $translator)
    {
        switch (htmlentities($request->query->get('entity') ?? '')) {
            case "processor":
                return $this->manageProcessors($request, $translator);
                break;
            case "coprocessor":
                return $this->manageCoprocessors($request, $translator);
                break;
            case "platform":
                return $this->managePlatforms($request, $translator);
                break;
            case "instructionset":
                return $this->manageInstructionsets($request, $translator);
                break;
            default:
                return $this->redirect(
                    $this->generateUrl('admin_manage_processing_units', array("entity" => "processor"))
                );
        }
    }


    #[Route(path: '/admin/manage/processingunits/coprocessors/add', name: 'new_coprocessor_add')]
    public function coprocessorAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderCoprocessorForm($request, new Coprocessor(), $entityManager);
    }


    #[Route(path: '/admin/manage/processingunits/coprocessors/{id}/edit', name: 'new_coprocessor_edit', requirements: ['id' => '\d+'])]
    public function coprocessorEdit(Request $request, int $id, CoprocessorRepository $coprocessorRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderCoprocessorForm(
            $request,
            $coprocessorRepository->find($id),
            $entityManager
        );
    }


    #[Route(path: '/admin/manage/processingunits/processors/add', name: 'new_processor_add')]
    public function processorAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderProcessorForm($request, new Processor(), $entityManager);
    }


    #[Route(path: '/admin/manage/processingunits/processors/{id}/edit', name: 'new_processor_edit', requirements: ['id' => '\d+'])]
    public function processorEdit(Request $request, int $id, ProcessorRepository $processorRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderProcessorForm(
            $request,
            $processorRepository->find($id),
            $entityManager
        );
    }


    #[Route(path: '/admin/manage/processingunits/platforms/add', name: 'new_processorPlatformType_add')]
    public function platformAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            new ProcessorPlatformType(),
            ProcessorPlatformTypeFormForm::class,
            'admin/edit/processingunits/processorPlatformType.html.twig',
            'platform',
            $entityManager
        );
    }


    #[Route(path: '/admin/manage/processingunits/platforms/{id}/edit', name: 'new_platform_edit', requirements: ['id' => '\d+'])]
    public function platformEdit(Request $request, int $id, ProcessorPlatformTypeRepository $processorPlatformTypeRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            $processorPlatformTypeRepository->find($id),
            ProcessorPlatformTypeFormForm::class,
            'admin/edit/processingunits/processorPlatformType.html.twig',
            'platform',
            $entityManager
        );
    }


    #[Route(path: '/admin/manage/processingunits/instructionsets/add', name: 'new_instructionSet_add')]
    public function instructionSetAdd(Request $request, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            new InstructionSet(),
            InstructionSetForm::class,
            'admin/edit/processingunits/instructionSet.html.twig',
            'instructionset',
            $entityManager
        );
    }


    #[Route(path: '/admin/manage/processingunits/instructionsets/{id}/edit', name: 'new_instructionSet_edit', requirements: ['id' => '\d+'])]
    public function instructionSetEdit(Request $request, int $id, InstructionSetRepository $instructionSetRepository, EntityManagerInterface $entityManager)
    {
        return $this->renderEntityForm(
            $request,
            $instructionSetRepository->find($id),
            InstructionSetForm::class,
            'admin/edit/processingunits/instructionSet.html.twig',
            'instructionset',
            $entityManager
        );
    }

    /**
     * Index pages
     */

    private function manageProcessors(Request $request, TranslatorInterface $translator)
    {
        $search = $this->createForm(ProcessorSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) {
                $getParams["manufacturer"] = $data['manufacturer']->getId();
            }
            if ($data['platform']) {
                $getParams["platform"] = $data['platform']->getId();
            }
            $getParams["entity"] = "processor";
            return $this->redirect($this->generateUrl('admin_manage_processing_units', $getParams));
        } else {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer') ?? '');
            if ($manufacturerId && intval($manufacturerId)) {
                $criterias["manufacturer"] = $manufacturerId;
            }
            $platformId = htmlentities($request->query->get('platform') ?? '');
            if ($platformId && intval($platformId)) {
                $criterias["platform"] = $platformId;
            }
        }

        return $this->render('admin/manage/processingunits/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ProcessingUnitController::listProcessor",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("processor"),
            "entityDisplayNamePlural" => $translator->trans("processors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageCoprocessors(Request $request, TranslatorInterface $translator)
    {
        $search = $this->createForm(ProcessorSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) {
                $getParams["manufacturer"] = $data['manufacturer']->getId();
            }
            if ($data['platform']) {
                $getParams["platform"] = $data['platform']->getId();
            }
            $getParams["entity"] = "coprocessor";
            return $this->redirect($this->generateUrl('admin_manage_processing_units', $getParams));
        } else {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer') ?? '');
            if ($manufacturerId && intval($manufacturerId)) {
                $criterias["manufacturer"] = $manufacturerId;
            }
            $platformId = htmlentities($request->query->get('platform') ?? '');
            if ($platformId && intval($platformId)) {
                $criterias["platform"] = $platformId;
            }
        }

        return $this->render('admin/manage/processingunits/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ProcessingUnitController::listCoprocessor",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("math coprocessor"),
            "entityDisplayNamePlural" => $translator->trans("math coprocessors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function managePlatforms(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/processingunits/manage.html.twig', [
            "search" => "",
            "criterias" => array(),
            "controllerList" => "App\\Controller\\Admin\\ProcessingUnitController::listPlatform",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("platform"),
            "entityDisplayNamePlural" => $translator->trans("platforms"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageInstructionsets(Request $request, TranslatorInterface $translator)
    {
        return $this->render('admin/manage/processingunits/manage.html.twig', [
            "search" => "",
            "criterias" => array(),
            "controllerList" => "App\\Controller\\Admin\\ProcessingUnitController::listInstructionset",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("instruction set"),
            "entityDisplayNamePlural" => $translator->trans("instruction sets"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function listProcessor(Request $request, PaginatorInterface $paginator, array $criterias, ProcessorRepository $processorRepository)
    {
        $processors = $processorRepository->findBy($criterias);
        $processors = Processor::sort(new ArrayCollection($processors));

        $paginatedProcessors = $paginator->paginate(
            $processors,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/processingunits/list.html.twig', [
            "objectList" => $paginatedProcessors,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function listCoprocessor(Request $request, PaginatorInterface $paginator, array $criterias, CoprocessorRepository $coprocessorRepository)
    {
        $coprocessors = $coprocessorRepository->findBy($criterias);
        $coprocessors = Coprocessor::sort(new ArrayCollection($coprocessors));

        $paginatedCoprocessors = $paginator->paginate(
            $coprocessors,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/processingunits/list.html.twig', [
            "objectList" => $paginatedCoprocessors,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function listPlatform(Request $request, PaginatorInterface $paginator, array $criterias, ProcessorPlatformTypeRepository $processorPlatformTypeRepository)
    {
        $platforms = $processorPlatformTypeRepository->findAll();

        usort($platforms, function (ProcessorPlatformType $a, ProcessorPlatformType $b) {
            return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
        });

        $paginatedPlatforms = $paginator->paginate(
            $platforms,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/processingunits/list.html.twig', [
            "objectList" => $paginatedPlatforms,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function listInstructionset(Request $request, PaginatorInterface $paginator, array $criterias, InstructionSetRepository $instructionSetRepository)
    {
        $instructionsets = $instructionSetRepository->findAll();

        usort($instructionsets, function (InstructionSet $a, InstructionSet $b) {
            return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
        });

        $paginatedInstructionsets = $paginator->paginate(
            $instructionsets,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/processingunits/list.html.twig', [
            "objectList" => $paginatedInstructionsets,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    /**
     * Forms
     */

    private function renderCoprocessorForm(Request $request, Coprocessor $coprocessor, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(CoprocessorForm::class, $coprocessor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $coprocessor = $form->getData();
            foreach ($form['processingUnit']['instructionSets']->getData() as $key => $val) {
                $val->addProcessingUnit($coprocessor);
            }
            foreach ($form['processingUnit']['chip']['chipAliases']->getData() as $key => $val) {
                $val->setChip($coprocessor);
            }
            foreach ($form['processingUnit']['chip']['images']->getData() as $key => $val) {
                $val->setChip($coprocessor);
            }

            $entityManager->persist($coprocessor);
            $entityManager->flush();

            return $this->redirect(
                $this->generateUrl('admin_manage_processing_units', array("entity" => "coprocessor"))
            );
        }
        return $this->render('admin/edit/processingunits/coprocessor.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function renderProcessorForm(Request $request, Processor $processor, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ProcessorForm::class, $processor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $processor = $form->getData();
            foreach ($form['processingUnit']['chip']['chipAliases']->getData() as $key => $val) {
                $val->setChip($processor);
            }
            foreach ($form['processingUnit']['chip']['images']->getData() as $key => $val) {
                $val->setChip($processor);
            }
            foreach ($form['voltages']->getData() as $key => $val) {
                $val->setProcessor($processor);
            }

            $entityManager->persist($processor);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('processor_show', array('id' => $processor->getId())));
        }
        return $this->render('admin/edit/processingunits/processor.html.twig', [
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

            return $this->redirect($this->generateUrl('admin_manage_processing_units', array("entity" => $entityName)));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }
}
