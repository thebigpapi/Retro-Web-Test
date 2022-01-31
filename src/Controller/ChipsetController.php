<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Form\Chipset\Search;
use App\Repository\ChipsetRepository;
use App\Repository\ManufacturerRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChipsetController extends AbstractController
{
    /**
     * @Route("/chipsets/{id}", name="chipset_show", requirements={"id"="\d+"})
     */
    public function show(int $id, ChipsetRepository $chipsetRepository)
    {
        $chipset = $chipsetRepository->find($id);

        return $this->render('chipset/show.html.twig', [
            'chipset' => $chipset,
            'controller_name' => 'ChipsetController',
        ]);
    }

    /**
     * @Route("/chipsets/", name="chipsetsearch", methods={"GET"})
     * @param Request $request
     */
    public function searchResult(Request $request, PaginatorInterface $paginator, ChipsetRepository $chipsetRepository)
    {
        $criterias = array();
        $name = htmlentities($request->query->get('name'));
        if ($name) $criterias['name'] = "$name";

        $chipsetId = htmlentities($request->query->get('chipsetId'));
        if ($chipsetId && intval($chipsetId)) $criterias['chipset'] = "$chipsetId";
        elseif ($chipsetId === "NULL") $criterias['chipset'] = null;

        $chipsetManufacturerId = htmlentities($request->query->get('chipsetManufacturerId'));
        if (
            $chipsetManufacturerId
            &&
            intval($chipsetManufacturerId)
            &&
            !array_key_exists('chipset', $criterias)
        ) {
            $criterias['manufacturer'] = "$chipsetManufacturerId";
        } elseif ($chipsetManufacturerId === "NULL" && !array_key_exists('chipset', $criterias)) {
            $criterias['manufacturer'] = null;
        }

        $showImages = boolval(htmlentities($request->query->get('showImages')));

        if ($criterias == array()) {
            return $this->redirectToRoute('chipset_search');
        }

        try {
            $data = $chipsetRepository->findByChipset($criterias);
        } catch (Exception $e) {
            return $this->redirectToRoute('chipset_search');
        }
        $chipsets = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('chipset/result.html.twig', [
            'controller_name' => 'ChipsetController',
            'chipsets' => $chipsets,
            'chipset_count' => count($data),
            'show_images' => $showImages,
        ]);
    }

    /**
     * @Route("/chipsets/search/", name="chipset_search")
     * @param Request $request
     */
    public function search(Request $request, TranslatorInterface $translator, ManufacturerRepository $manufacturerRepository)
    {
        $notIdentifiedMessage = $translator->trans("Not identified");

        $chipsetManufacturers = $manufacturerRepository->findAllChipsetManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift($chipsetManufacturers, $unidentifiedMan);


        $form = $this->createForm(Search::class, array(), [
            'chipsetManufacturers' => $chipsetManufacturers,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('chipsetsearch', $this->searchFormToParam($request, $form)));
        }
        return $this->render('chipset/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();

        if ($form['searchWithImages']->isClicked()) {
            $parameters['showImages'] = true;
        }

        if ($form['chipsetManufacturer']->getData()) {
            if ($form['chipsetManufacturer']->getData()->getId() == 0) {
                $parameters['chipsetManufacturerId']  = "NULL";
            } else {
                $parameters['chipsetManufacturerId'] = $form['chipsetManufacturer']->getData()->getId();
            }
        }
        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }

    /**
     * @Route("/chipsets/index/{letter}", name="chipsetindex", requirements={"letter"="\w|[?]"}), methods={"GET"})
     * @param Request $request
     */
    public function index(Request $request, PaginatorInterface $paginator, string $letter, ChipsetRepository $chipsetRepository)
    {
        if ($letter == "?") $letter = "";
        $data = $chipsetRepository->findAllAlphabetic($letter);

        usort(
            $data,
            function ($a, $b) {
                if ($a->getManufacturer() == $b->getManufacturer()) {
                    return 0;
                }
                return ($a->getManufacturer() < $b->getManufacturer()) ? -1 : 1;
            }
        );

        $chipsets = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('chipset/index.html.twig', [
            'chipsets' => $chipsets,
            'chipset_count' => count($data),
        ]);
    }
}
