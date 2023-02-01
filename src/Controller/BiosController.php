<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Manufacturer;
use App\Entity\MotherboardBios;
use App\Form\Bios\Search;
use App\Entity\ManufacturerBiosManufacturerCode;
use App\Entity\ChipsetBiosCode;
use App\Repository\ManufacturerBiosManufacturerCodeRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\ExpansionChipRepository;
use App\Repository\MotherboardBiosRepository;

class BiosController extends AbstractController
{

    
    #[Route(path: '/bios/', name: 'bios_result')]
    public function result(Request $request, PaginatorInterface $paginator, MotherboardBiosRepository $motherboardBiosRepository, ManufacturerRepository $manufacturerRepository, ManufacturerBiosManufacturerCodeRepository $manufacturerBiosManufacturerCodeRepository)
    {
        $criterias = array();
        $postString = $request->query->get('postString');
        if ($postString) {
            $criterias['post_string'] = "$postString";
        }
        $coreVersion = htmlentities($request->query->get('coreVersion') ?? '');
        if ($coreVersion) {
            $criterias['core_version'] = "$coreVersion";
        }
        $biosManufacturerId = htmlentities($request->query->get('biosManufacturerId') ?? '');
        if ($biosManufacturerId && intval($biosManufacturerId)) {
            $criterias['manufacturer_id'] = intval($biosManufacturerId);
        } elseif ($biosManufacturerId == "NULL") {
            $criterias['manufacturer_id'] = null;
        }
        /*$expansionChipId = htmlentities($request->query->get('expansionChipId') ?? '');
        if ($expansionChipId && intval($expansionChipId)) {
            $criterias['expansionchip_id'] = intval($expansionChipId);
        } elseif ($expansionChipId == "NULL") {
            $criterias['expansionchip_id'] = null;
        }*/
        $filePresent = htmlentities($request->query->get('filePresent') ?? '');
        if ($filePresent && boolval($filePresent)) {
            $criterias['file_present'] = boolval($filePresent);
        }
        $chipsetId = htmlentities($request->query->get('chipsetId') ?? '');
        if ($chipsetId && intval($chipsetId)) {
            $criterias['chipset_id'] = intval($chipsetId);
        } elseif ($chipsetId == "NULL") {
            $criterias['chipset_id'] = null;
        }
        if (empty($criterias)) {
            return $this->redirectToRoute("bios_search");
        }
        $data = $motherboardBiosRepository->findBios($criterias);
        // this doesn't really work as it should, disabled :))
        /*
        $postStringAnalysis = false;
        if (empty($data)) {
            try {
                if ($postString && $biosManufacturerId && intval($biosManufacturerId)) {
                    $biosManufacturer = $manufacturerRepository->find($biosManufacturerId);
                    if ($biosManufacturer->getShortNameIfExist() == "AMI") {
                        $subStr = explode("-", $postString);
                        if (substr_count($postString, "-") == 3) { //Old AMI
                            $mfgCode = $subStr[1];
                        } else { //New AMI
                            $mfgCode = substr($subStr[2], 2);
                        }
                    } elseif ($biosManufacturer->getShortNameIfExist() == "Award") {
                        $subStr = explode("-", $postString);
                        dd($subStr);
                        $mfgCode = substr($subStr[count($subStr) - 2], 5, 2);
                        
                    }
                    
                    $biosCodes = $manufacturerBiosManufacturerCodeRepository->findBy(array("biosManufacturer" => $biosManufacturer));
                    $manufacturers = array();
                    foreach ($biosCodes as $biosCode) {
                        if ($mfgCode == $biosCode->getCode()) {
                            $manufacturers[] = $biosCode->getManufacturer()->getId();
                        }
                    };
                    if (!empty($manufacturers)) {
                        $criterias['motherboard_manufacturer_ids'] = $manufacturers;
                        $postStringAnalysis = true;
                        $data = $motherboardBiosRepository->findBios($criterias);
                    }
                }
            } catch (\Exception $e) {
            }
        }*/
        $bios = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );
        return $this->render('bios/result.html.twig', [
            'bios' => $bios,
            'bios_count' => count($data),
            'postStringAnalysis' => false,
        ]);
    }
    #[Route(path: '/bios/info', name: 'bios_info')]
    public function binfo()
    {
        return $this->render('bios/info.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route(path: '/bios/infoadv', name: 'bios_infoadv')]
    public function binfoadv(ManufacturerRepository $manufacturerRepository)
    {
        $biosCodes = $manufacturerRepository->findAllBiosManufacturer2();
        $chipdata = $manufacturerRepository->findAllChipsetBiosManufacturer();
        return $this->render('bios/infoadv.html.twig', [
            'controller_name' => 'MainController',
            'biosCodes' => $biosCodes,
            'chipCodes' => $chipdata,
        ]);
    }

    
    #[Route(path: '/bios/search/', name: 'bios_search')]
    public function search(Request $request, TranslatorInterface $translator, ManufacturerRepository $manufacturerRepository, ExpansionChipRepository $expansionChipRepository)
    {
        $notIdentifiedMessage = $translator->trans("Not identified");
        $chipsetManufacturers = $manufacturerRepository->findAllChipsetManufacturer();
        $biosManufacturers = $manufacturerRepository->findAllBiosManufacturer();
        $expansionChip = $expansionChipRepository->findAll();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName($notIdentifiedMessage);
        $form = $this->createForm(Search::class, array(), [
            'biosManufacturers' => $biosManufacturers,
            'expansionChips' => $expansionChip,
            'chipsetManufacturers' => $chipsetManufacturers,
            //'csrf_protection' => false // that code is aimed to remove cookie requirement but it breaks ajax stuff
        ]);
        //dd($expansionChip);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $parameters = array();

            if ($postString = $form['post_string']->getData()) {
                $parameters['postString'] = $postString;
            }
            if ($coreVersion = $form['core_version']->getData()) {
                $parameters['coreVersion'] = $coreVersion;
            }
            if ($biosManufacturer = $form['manufacturer']->getData()) {
                $parameters['biosManufacturerId'] = $biosManufacturer->getId();
            }
            /*if ($expansionChip = $form['expansionChip']->getData()) {
                $parameters['expansionChipId'] = $expansionChip->getId();
            }*/
            if ($filePresent = $form['file_present']->getData()) {
                $parameters['filePresent'] = $filePresent;
            }
            if ($chipset = $form['chipset']->getData()) {
                $parameters['chipsetId'] = $chipset->getId();
            }

            return $this->redirect($this->generateUrl('bios_result', $parameters));
        }
        return $this->render('bios/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
