<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Contracts\Translation\TranslatorInterface;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Motherboard;
use App\Entity\Manufacturer;
use App\Entity\Chipset;
use App\Entity\MotherboardBios;
use App\Form\Bios\Search;

class BiosController extends AbstractController
{

    /**
     * @Route("/bios/result", name="bios_result"), methods={"GET"})
     * @param Request $request
     */
    public function result(Request $request, PaginatorInterface $paginator)
    {
        $criterias = array();

        $postString = htmlentities($request->query->get('postString'));
        if ($postString) $criterias['post_string'] = "$postString";

        $coreVersion = htmlentities($request->query->get('coreVersion'));
        if ($coreVersion) $criterias['core_version'] = "$coreVersion";

        $biosManufacturerId = htmlentities($request->query->get('biosManufacturerId'));
        if ($biosManufacturerId && intval($biosManufacturerId)) $criterias['manufacturer_id'] = intval($biosManufacturerId);
        elseif ($biosManufacturerId == "NULL") $criterias['manufacturer_id'] = NULL;

        $filePresent = htmlentities($request->query->get('filePresent'));
        if ($filePresent && boolval($filePresent)) $criterias['file_present'] = boolval($filePresent);

        $chipsetId = htmlentities($request->query->get('chipsetId'));
        if ($chipsetId && intval($chipsetId)) $criterias['chipset_id'] = intval($chipsetId);
        elseif ($chipsetId == "NULL") $criterias['chipset_id'] = NULL;

        $data = $this->getDoctrine()
            ->getRepository(MotherboardBios::class)
            ->findBios($criterias);

        $bios = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('bios/result.html.twig', [
            'bios' => $bios,
            'bios_count' => count($bios),
        ]);
    }
	/**
     * @Route("/bios/info", name="bios_info")
     */
    public function binfo()
    {        
        return $this->render('bios/info.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
	/**
     * @Route("/bios/infoadv", name="bios_infoadv")
     */
    public function binfoadv()
    {        
        return $this->render('bios/infoadv.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/bios/search", name="bios_search"), methods={"GET"})
     * @param Request $request
     */
    public function search(Request $request, TranslatorInterface $translator)
    {
        $notIdentifiedMessage = $translator->trans("Not identified");
        $chipsetManufacturers = $this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->findAllChipsetManufacturer();


        $biosManufacturers = $this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->findAllBiosManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        array_unshift ($chipsetManufacturers, $unidentifiedMan);
        

        $form = $this->createForm(Search::class, array(), [
            'biosManufacturers' => $biosManufacturers,
            'chipsetManufacturers' => $chipsetManufacturers,
            ]);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('searchChipsetManufacturer')->isClicked()){
                return $this->render('bios/search.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            $parameters = array();
            //dd($form->getData());

            if($postString = $form['post_string']->getData()) {
                $parameters['postString'] = $postString;
            }
            if($coreVersion = $form['core_version']->getData()) {
                $parameters['coreVersion'] = $coreVersion;
            }
            if($biosManufacturer = $form['manufacturer']->getData()) {
                $parameters['biosManufacturerId'] = $biosManufacturer->getId();
            }
            if($filePresent = $form['file_present']->getData()) {
                $parameters['filePresent'] = $filePresent;
            }
            if($chipset = $form['chipset']->getData()) {
                $parameters['chipsetId'] = $chipset->getId();
            }

            return $this->redirect($this->generateUrl('bios_result', $parameters));
        }
        return $this->render('bios/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}