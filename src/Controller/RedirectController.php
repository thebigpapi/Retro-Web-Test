<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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


    #[Route(path: '/motherboard/index/{letter}', requirements: ['letter' => '\w'])]
    public function redirectIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('moboindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
    }

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


    #[Route(path: '/{lang}/motherboards/index/{letter}', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru', 'letter' => '\w'])]
    public function redirectLangMoboIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('moboindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
    }
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


    #[Route(path: '/{lang}/chipsets/index/{letter}', requirements: ['lang' => 'de|en|es|fr|it|nl|ro|ru', 'letter' => '\w'])]
    public function redirectLangChipsetIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('chipsetindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
    }
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
