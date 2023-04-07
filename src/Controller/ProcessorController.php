<?php

namespace App\Controller;

use App\Entity\Processor;
use App\Entity\Manufacturer;
use App\Form\Processor\Search;
use App\Repository\ProcessorRepository;
use App\Repository\ManufacturerRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ProcessorController extends AbstractController
{
    #[Route('/cpus/{id}', name:'processor_show', requirements:['id' => '\d+'])]
    public function show(int $id, ProcessorRepository $cpuRepository): Response
    {
        $cpu = $cpuRepository->find($id);
        if (!$cpu) {
            throw $this->createNotFoundException(
                'No $cpu found for id ' . $id
            );
        } else {
            return $this->render('cpu/show.html.twig', [
                'cpu' => $cpu,
                'controller_name' => 'ProcessorController',
            ]);
        }
    }

    #[Route('/cpus/', name:'processorsearch', methods:['GET'])]
    public function searchResult(Request $request, PaginatorInterface $paginator, ProcessorRepository $cpuRepository): Response
    {
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $cpuManufacturerId = htmlentities($request->query->get('cpuManufacturerId') ?? '');
        if (
            $cpuManufacturerId
            &&
            intval($cpuManufacturerId)
            &&
            !array_key_exists('cpu', $criterias)
        ) {
            $criterias['manufacturer'] = "$cpuManufacturerId";
        } elseif ($cpuManufacturerId === "NULL" && !array_key_exists('cpu', $criterias)) {
            $criterias['manufacturer'] = null;
        }
        if ($criterias == array()) {
            return $this->redirectToRoute('processor_search');
        }

        try {
            $data = $cpuRepository->findByCPU($criterias);
        } catch (Exception $e) {
            return $this->redirectToRoute('processor_search');
        }
        $cpus = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('cpu/result.html.twig', [
            'controller_name' => 'ProcessorController',
            'cpus' => $cpus,
            'cpu_count' => count($data),
        ]);
    }

    #[Route('/cpus/search/', name:'processor_search')]
    public function search(Request $request, ProcessorRepository $cpuRepository, ManufacturerRepository $manufacturerRepository): Response
    {
        $notIdentifiedMessage = "Not identified";
        $cpuManufacturers = $manufacturerRepository->findAllProcessorManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($cpuManufacturers, $unidentifiedMan);
        $form = $this->createForm(Search::class, array(), [
            'cpuManufacturers' => $cpuManufacturers,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('processorsearch', $this->searchFormToParam($request, $form)));
        }
        return $this->render('cpu/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();
        if ($form['cpuManufacturer']->getData()) {
            if ($form['cpuManufacturer']->getData()->getId() == 0) {
                $parameters['cpuManufacturerId']  = "NULL";
            } else {
                $parameters['cpuManufacturerId'] = $form['cpuManufacturer']->getData()->getId();
            }
        }
        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }

    #[Route('/cpus/index/{letter}', name:'processorindex', requirements:['letter' => '\w|[?]'], methods:["GET"])]
    public function index(Request $request, PaginatorInterface $paginator, string $letter, ProcessorRepository $cpuRepository): Response
    {
        if ($letter === "?") {
            $letter = "";
        }
        $data = $cpuRepository->findAllAlphabetic($letter);

        usort(
            $data,
            function (Processor $a, Processor $b) {
                return strcmp($a->getName(), $b->getName());
            }
        );

        $cpus = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('cpu/index.html.twig', [
            'cpus' => $cpus,
            'cpu_count' => count($data),
            'letter' => $letter,
        ]);
    }
}
