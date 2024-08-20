<?php

namespace App\Controller;

use App\Repository\CdDriveRepository;
use App\Repository\ChipRepository;
use App\Repository\FloppyDriveRepository;
use App\Repository\HardDriveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RedirectController extends AbstractController
{
    public function redirectToLocale(): Response
    {
        return $this->redirectToRoute('app_homepage');
    }
    /* ==== WIN3X REDIRECTS ==== */

    #[Route(path: '/hardware/motherboard/result/', methods: ['GET'])]
    public function redirectSearch(Request $request)
    {
        return $this->redirect($this->generateUrl('mobosearch', $request->query->all()));
    }

    #[Route(path: '/motherboard/show/{id}')]
    public function redirectShow($id)
    {
        return $this->redirect($this->generateUrl('motherboard_show', array("id" => $id)));
    }


    #[Route(path: '/motherboard/search/')]
    public function redirectNewSearch()
    {
        return $this->redirect($this->generateUrl('mobosearch'));
    }
    #[Route(path: '/motherboards/search/')]
    public function redirectNewSearchWithS()
    {
        return $this->redirect($this->generateUrl('mobosearch'));
    }
    #[Route(path: '/chipsets/search/')]
    public function redirectChipsetNewSearch()
    {
        return $this->redirect($this->generateUrl('chipsetsearch'));
    }
    #[Route(path: '/bios/search/')]
    public function redirectBiosNewSearch()
    {
        return $this->redirect($this->generateUrl('biossearch'));
    }
    #[Route(path: '/drivers/search/')]
    public function redirectDriverNewSearch()
    {
        return $this->redirect($this->generateUrl('driversearch'));
    }
    #[Route(path: '/cpus/search/')]
    public function redirectCpuNewSearch()
    {
        return $this->redirect($this->generateUrl('cpusearch'));
    }


    /*#[Route(path: '/motherboard/index/{letter}', requirements: ['letter' => '\w'])]
    public function redirectIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('moboindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
    }*/

    #[Route(path: '/{lang}/motherboards/search', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru'])]
    public function redirectLangMoboSearch()
    {
        return $this->redirect($this->generateUrl('motherboard_search'));
    }

    #[Route(path: '/{lang}/motherboards/{id}', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru'])]
    public function redirectLangMoboShow($id)
    {
        return $this->redirect($this->generateUrl('motherboard_show', array("id" => $id)));
    }


    /*#[Route(path: '/{lang}/motherboards/index/{letter}', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru', 'letter' => '\w'])]
    public function redirectLangMoboIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('moboindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
    }*/

    #[Route(path: '/{lang}/bios/search', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru'])]
    public function redirectLangBiosSearch()
    {
        return $this->redirect($this->generateUrl('bios_search'));
    }

    #[Route(path: '/{lang}/bios/info', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru'])]
    public function redirectLangBiosInfo()
    {
        return $this->redirect($this->generateUrl('bios_info'));
    }

    #[Route(path: '/{lang}/bios/infoadv', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru'])]
    public function redirectLangBiosInfoadv()
    {
        return $this->redirect($this->generateUrl('bios_infoadv'));
    }
    #[Route(path: '/{lang}/chipsets/search', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru'])]
    public function redirectLangChipsetSearch()
    {
        return $this->redirect($this->generateUrl('chipset_search'));
    }

    #[Route(path: '/{lang}/chipsets/{id}', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru'])]
    public function redirectLangChipsetShow($id)
    {
        return $this->redirect($this->generateUrl('chipset_show', array("id" => $id)));
    }


    #[Route(path: '/storage/{id}', name:'storage_show', requirements:['id' => '\d+'])]
    public function redirectStorage($id, HardDriveRepository $hardDriveRepository, CdDriveRepository $cdDriveRepository, FloppyDriveRepository $floppyDriveRepository)
    {
        $hdd = $hardDriveRepository->find($id);
        if (!$hdd) {
            $cdd = $cdDriveRepository->find($id);
            if (!$cdd) {
                $fdd = $floppyDriveRepository->find($id);
                if (!$fdd) {
                    throw $this->createNotFoundException('No storage device found for id ' . $id);
                }
                return $this->redirect($this->generateUrl('floppy_drive_show', array("id" => $id)));
            }
            return $this->redirect($this->generateUrl('cd_drive_show', array("id" => $id)));
        }
        return $this->redirect($this->generateUrl('hard_drive_show', array("id" => $id)));
    }

    /*#[Route(path: '/chip/{id}')]
    public function redirectChip($id, ExpansionChipRepository $expansionChipRepository, ProcessorRepository $processorRepository)
    {
        $chip = $expansionChipRepository->find($id);
        if (!$chip) {
            $chip = $processorRepository->find($id);
            if (!$chip) {
                throw $this->createNotFoundException('No chip found for id ' . $id);
            }
            return $this->redirect($this->generateUrl('processor_show', array("id" => $id)));
        }
        return $this->redirect($this->generateUrl('expansion_chip_show', array("id" => $id)));
    }
    todo: expansion-chips, cpus
    */

    /* credits redirect */
    #[Route(path: '/credits', methods: ['GET'])]
    public function redirectCredits(Request $request)
    {
        return $this->redirect($this->generateUrl('app_credits'));
    }
    /* bios info redirect */
    #[Route(path: '/bios/info', methods: ['GET'])]
    public function redirectBiosInfo(Request $request)
    {
        return $this->redirect($this->generateUrl('bios_list'));
    }
    #[Route(path: '/bios/infoadv', methods: ['GET'])]
    public function redirectBiosInfoAdv(Request $request)
    {
        return $this->redirect($this->generateUrl('bios_list'));
    }
    
}
