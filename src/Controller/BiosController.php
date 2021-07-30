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
use App\Entity\ManufacturerBiosManufacturerCode;
use App\Entity\ChipsetBiosCode;

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

        if (empty($criterias)) {
            return $this->redirectToRoute("bios_search");
        }

        $data = $this->getDoctrine()
            ->getRepository(MotherboardBios::class)
            ->findBios($criterias);
        
        $postStringAnalysis = false;
        if(empty($data)) {
            try {
                if($postString && $biosManufacturerId && intval($biosManufacturerId)) {
                    $biosManufacturer = $this->getDoctrine()
                    ->getRepository(Manufacturer::class)
                    ->find($biosManufacturerId);

                    if($biosManufacturer->getShortNameIfExist() == "AMI") {
                        $subStr = explode("-", $postString);
                        if (substr_count($postString, "-") == 3) { //Old AMI
                            $mfgCode = $subStr[1]; 
                        }
                        else { //New AMI
                            $mfgCode = substr($subStr[2], 2);
                        }
                    }
                    else if ($biosManufacturer->getShortNameIfExist() == "Award") {
                        $subStr = explode("-", $postString);
                        $mfgCode = substr($subStr[count($subStr) - 2], 5, 2);
                    }

                    $biosCodes = $this->getDoctrine()->
                        getRepository(ManufacturerBiosManufacturerCode::class)->
                        findBy(array("biosManufacturer"=>$biosManufacturer));
                    
                    $manufacturers = array();
                    foreach ($biosCodes as $biosCode) {
                        if($mfgCode == $biosCode->getCode()) {
                            $manufacturers[] = $biosCode->getManufacturer()->getId();
                        }
                    };
                    if (!empty($manufacturers)) {
                        $criterias['motherboard_manufacturer_ids'] = $manufacturers;
                        $postStringAnalysis = true;
                        $data = $this->getDoctrine()
                            ->getRepository(MotherboardBios::class)
                            ->findBios($criterias);
                    }
                }
            }
            catch (\Exception $e) {}
        }

        $bios = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('bios/result.html.twig', [
            'bios' => $bios,
            'bios_count' => count($data),
            'postStringAnalysis' => $postStringAnalysis,
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
        $biosCodes = $this->getDoctrine()->getRepository(ManufacturerBiosManufacturerCode::class)->findAll();
        $chipCodes = $this->getDoctrine()->getRepository(ChipsetBiosCode::class)->findAll();

        $data = array();
        $chipdata = array();

        foreach ($biosCodes as $code)
        {
            $sn = $code->getBiosManufacturer()->getShortNameIfExist();
            $data[$sn][] = $code;
        }

        foreach ($data as $key => $codes)
        {    
            usort($codes, function ($a, $b)
                {
                    if ($a->getCode() == $b->getCode()) {
                        return 0;
                    }
                    return ($a->getCode() < $b->getCode()) ? -1 : 1;
                }
            );
            $data[$key] = $codes;
        }

        foreach ($chipCodes as $chcode)
        {
            $sna = $chcode->getBiosManufacturer()->getShortNameIfExist();
            $chipdata[$sna][] = $chcode;
        }

        foreach ($chipdata as $key => $codes)
        {    
            usort($codes, function ($a, $b)
                {
                    if ($a->getCode() == $b->getCode()) {
                        return 0;
                    }
                    return ($a->getCode() < $b->getCode()) ? -1 : 1;
                }
            );
            $chipdata[$key] = $codes;
        }

        return $this->render('bios/infoadv.html.twig', [
            'controller_name' => 'MainController',
            'biosCodes' => $data,
            'chipCodes' => $chipdata,
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
        //    'csrf_protection' => false	// that code is aimed to remove cookie requirement but it breaks ajax stuff
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