<?php
namespace App\Controller\Admin;

use App\Entity\Coprocessor;
use App\Entity\InstructionSet;
use App\Entity\Processor;
use App\Entity\ProcessorPlatformType;
use App\Form\Admin\Manage\ProcessorSearchType;
use App\Form\EditCoprocessor;
use App\Form\EditInstructionSet;
use App\Form\EditProcessor;
use App\Form\EditProcessorPlatformType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProcessingUnitController extends AbstractController {


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/processingunits", name="admin_manage_processing_units")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)        
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "processor":
                return $this->manage_processors($request, $translator);
                break;
            case "coprocessor":
                return $this->manage_coprocessors($request, $translator);
                break;
            case "platform":
                return $this->manage_platforms($request, $translator);
                break;
            case "instructionset":
                return $this->manage_instructionsets($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_processing_units', array("entity" => "processor")));
        }
    }

    /**
     * @Route("/admin/manage/processingunits/coprocessors/add", name="new_coprocessor_add")
     * @param Request $request
     */
    public function coprocessorAdd(Request $request)        
    {
        return $this->renderCoprocessorForm($request, new Coprocessor());
    }

    /**
     * @Route("/admin/manage/processingunits/coprocessors/{id}/edit", name="new_coprocessor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function coprocessorEdit(Request $request, int $id)        
    {
        return $this->renderCoprocessorForm($request, 
            $this->getDoctrine()
            ->getRepository(Coprocessor::class)
            ->find($id)
        );
    }

    /**
     * @Route("/admin/manage/processingunits/processors/add", name="new_processor_add")
     * @param Request $request
     */
    public function processorAdd(Request $request)        
    {
        return $this->renderProcessorForm($request, new Processor());
    }

    /**
     * @Route("/admin/manage/processingunits/processors/{id}/edit", name="new_processor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function processorEdit(Request $request, int $id)        
    {
        return $this->renderProcessorForm($request, 
            $this->getDoctrine()
            ->getRepository(Processor::class)
            ->find($id)
        );
    }

    /**
     * @Route("/admin/manage/processingunits/platforms/add", name="new_processorPlatformType_add")
     * @param Request $request
     */
    public function platformAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new ProcessorPlatformType(), EditProcessorPlatformType::class, 'admin/add_processorPlatformType.html.twig', 'platform');
    }

    /**
     * @Route("/admin/manage/processingunits/platforms/{id}/edit", name="new_platform_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function platformEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request, $this->getDoctrine()
            ->getRepository(ProcessorPlatformType::class)
            ->find($id)
            , EditProcessorPlatformType::class, 'admin/add_processorPlatformType.html.twig', 'platform');
    }

    /**
     * @Route("/admin/manage/processingunits/instructionsets/add", name="new_instructionSet_add")
     * @param Request $request
     */
    public function instructionSetAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new InstructionSet(), EditInstructionSet::class, 'admin/add_instructionSet.html.twig', 'instructionset');
    }

    /**
     * @Route("/admin/manage/processingunits/instructionsets/{id}/edit", name=",new_instructionSet_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function instructionSetEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
            ->getRepository(InstructionSet::class)
            ->find($id)
        , EditInstructionSet::class, 'admin/add_instructionSet.html.twig', 'instructionset');
    }

    /**
     * Index pages
     */

    private function manage_processors(Request $request, TranslatorInterface $translator)        
    {
        $search = $this->createForm(ProcessorSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) $getParams["manufacturer"] = $data['manufacturer']->getId();
            if ($data['platform']) $getParams["platform"] = $data['platform']->getId();
            $getParams["entity"] = "processor";
            return $this->redirect($this->generateUrl('admin_manage_processing_units', $getParams));
        }
        else
        {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer'));
            if ($manufacturerId && intval($manufacturerId))
                $criterias["manufacturer"] = $manufacturerId;
            $platformId = htmlentities($request->query->get('platform'));
            if ($platformId && intval($platformId))
                $criterias["platform"] = $platformId;
        }

        return $this->render('admin/manage/processingunits/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ProcessingUnitController::list_processor",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("processor"),
            "entityDisplayNamePlural" => $translator->trans("processors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_coprocessors(Request $request, TranslatorInterface $translator)        
    {
        $search = $this->createForm(ProcessorSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) $getParams["manufacturer"] = $data['manufacturer']->getId();
            if ($data['platform']) $getParams["platform"] = $data['platform']->getId();
            $getParams["entity"] = "coprocessor";
            return $this->redirect($this->generateUrl('admin_manage_processing_units', $getParams));
        }
        else
        {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer'));
            if ($manufacturerId && intval($manufacturerId))
                $criterias["manufacturer"] = $manufacturerId;
            $platformId = htmlentities($request->query->get('platform'));
            if ($platformId && intval($platformId))
                $criterias["platform"] = $platformId;
        }

        return $this->render('admin/manage/processingunits/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ProcessingUnitController::list_coprocessor",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("math coprocessor"),
            "entityDisplayNamePlural" => $translator->trans("math coprocessors"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_platforms(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/processingunits/manage.html.twig', [
            "search" => "",
            "criterias" => array(),
            "controllerList" => "App\\Controller\\Admin\\ProcessingUnitController::list_platform",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("platform"),
            "entityDisplayNamePlural" => $translator->trans("platforms"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_instructionsets(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/processingunits/manage.html.twig', [
            "search" => "",
            "criterias" => array(),
            "controllerList" => "App\\Controller\\Admin\\ProcessingUnitController::list_instructionset",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("instruction set"),
            "entityDisplayNamePlural" => $translator->trans("instruction sets"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function list_processor(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $processors = $this->getDoctrine()
            ->getRepository(Processor::class)
            ->findBy($criterias);
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

    public function list_coprocessor(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $coprocessors = $this->getDoctrine()
            ->getRepository(Coprocessor::class)
            ->findBy($criterias);
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

    public function list_platform(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $platforms = $this->getDoctrine()
            ->getRepository(ProcessorPlatformType::class)
            ->findAll();

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

    public function list_instructionset(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $instructionsets = $this->getDoctrine()
            ->getRepository(InstructionSet::class)
            ->findAll();

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

    private function renderCoprocessorForm(Request $request, Coprocessor $coprocessor) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(EditCoprocessor::class, $coprocessor);
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

            return $this->redirect($this->generateUrl('admin_manage_processing_units', array("entity" => "coprocessor"))); 
        }
        return $this->render('admin/add_coprocessor.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function renderProcessorForm(Request $request, Processor $processor) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(EditProcessor::class, $processor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $processor = $form->getData();
            foreach ($form['processingUnit']['instructionSets']->getData() as $key => $val) {
                $val->addProcessingUnit($processor);
            }
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

            return $this->redirect($this->generateUrl('admin_manage_processing_units', array("entity" => "processor")));
        }
        return $this->render('admin/add_processor.html.twig', [
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

            return $this->redirect($this->generateUrl('admin_manage_processing_units', array("entity" => $entityName)));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }
}