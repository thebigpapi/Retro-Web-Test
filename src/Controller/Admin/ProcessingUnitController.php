<?php
namespace App\Controller\Admin;

use App\Entity\Coprocessor;
use App\Entity\Processor;
use App\Form\Admin\Manage\ProcessorSearchType;
use App\Form\EditCoprocessor;
use App\Form\EditProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ProcessingUnitController extends AbstractController {


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/processingunits", name="admin_manage_processing_units")
     * @param Request $request
     */
    public function manage(Request $request, PaginatorInterface $paginator)        
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "processor":
                return $this->manage_processors($request, $paginator);
                break;
            case "coprocessor":
                return $this->manage_coprocessors($request, $paginator);
            default:
                return $this->manage_processors($request, $paginator);
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
     * Index pages
     */

    private function manage_processors(Request $request, PaginatorInterface $paginator)        
    {
        $processorSearch = $this->createForm(ProcessorSearchType::class);

        $getParams = array();
        $processorSearch->handleRequest($request);
        if ($processorSearch->isSubmitted() && $processorSearch->isValid()) {
            $data = $processorSearch->getData();
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

        $processors = $this->getDoctrine()
            ->getRepository(Processor::class)
            ->findBy($criterias);
        $processors = Processor::sort(new ArrayCollection($processors));

        $paginatedProcessors = $paginator->paginate(
            $processors,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/processingunits/manage_processors.html.twig', [
            "processorSearch" => $processorSearch->createView(),
            "processors" => $paginatedProcessors,
        ]);
    }

    private function manage_coprocessors(Request $request, PaginatorInterface $paginator)        
    {
        $coprocessorSearch = $this->createForm(ProcessorSearchType::class);

        $getParams = array();
        $coprocessorSearch->handleRequest($request);
        if ($coprocessorSearch->isSubmitted() && $coprocessorSearch->isValid()) {
            $data = $coprocessorSearch->getData();
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

        $coprocessors = $this->getDoctrine()
            ->getRepository(Coprocessor::class)
            ->findBy($criterias);
        $coprocessors = Coprocessor::sort(new ArrayCollection($coprocessors));

        $paginatedCoprocessors = $paginator->paginate(
            $coprocessors,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/processingunits/manage_coprocessors.html.twig', [
            "coprocessorSearch" => $coprocessorSearch->createView(),
            "coprocessors" => $paginatedCoprocessors,
        ]);
    }

    /**
     * Forms
     */

    private function renderCoprocessorForm(Request $request, $coprocessor) {
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

            return $this->redirectToRoute('admin_manage_resources', array()); 
        }
        return $this->render('admin/add_coprocessor.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function renderProcessorForm(Request $request, $processor) {
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

            return $this->redirectToRoute('admin_manage_resources', array());
        }
        return $this->render('admin/add_processor.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}