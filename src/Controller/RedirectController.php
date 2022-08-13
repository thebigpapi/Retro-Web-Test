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
    /**
     * @Route("/hardware/motherboard/result/", methods={"GET"})
     * @param Request $request
     */
    public function redirectSearch(Request $request)
    {
        return $this->redirect($this->generateUrl('mobosearch', $request->query->all()));
    }

    /**
     * @Route("/motherboard/show/{id}")
     */
    public function redirectShow($id)
    {
        return $this->redirect($this->generateUrl('motherboard_show', array("id" => $id)));
    }

    /**
     * @Route("/motherboard/search/")
     * @param Request $request
     */
    public function redirectNewSearch()
    {
        return $this->redirect($this->generateUrl('motherboard_search'));
    }

    /**
     * @Route("/motherboard/index/{letter}", requirements={"letter"="\w"}), methods={"GET"})
     * @param Request $request
     */
    public function redirectIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('moboindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
    }

    /* ==== LANGUAGE REDIRECTS (from UR) ==== */
    /* -- motherboards -- */
    /**
     * @Route("/{lang}/motherboards/search", requirements={"lang": "de|en|es|fr|it|nl|ro|ru"})
     */
    public function redirectLangMoboSearch()
    {
        return $this->redirect($this->generateUrl('motherboard_search'));
    }

    /**
     * @Route("/{lang}/motherboards/{id}", requirements={"lang": "de|en|es|fr|it|nl|ro|ru"})
     */
    public function redirectLangMoboShow($id)
    {
        return $this->redirect($this->generateUrl('motherboard_show', array("id" => $id)));
    }

    /**
     * @Route("/{lang}/motherboards/index/{letter}", requirements={"lang": "de|en|es|fr|it|nl|ro|ru", "letter"="\w"}), methods={"GET"})
     * @param Request $request
     */
    public function redirectLangMoboIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('moboindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
    }
    /* -- BIOS -- */
    /**
     * @Route("/{lang}/bios/search", requirements={"lang": "de|en|es|fr|it|nl|ro|ru"})
     */
    public function redirectLangBiosSearch()
    {
        return $this->redirect($this->generateUrl('bios_search'));
    }

    /**
     * @Route("/{lang}/bios/info", requirements={"lang": "de|en|es|fr|it|nl|ro|ru"})
     */
    public function redirectLangBiosInfo()
    {
        return $this->redirect($this->generateUrl('bios_info'));
    }

    /**
     * @Route("/{lang}/bios/infoadv", requirements={"lang": "de|en|es|fr|it|nl|ro|ru"})
     */
    public function redirectLangBiosInfoadv()
    {
        return $this->redirect($this->generateUrl('bios_infoadv'));
    }
    /* -- chipsets -- */
    /**
     * @Route("/{lang}/chipsets/search", requirements={"lang": "de|en|es|fr|it|nl|ro|ru"})
     */
    public function redirectLangChipsetSearch()
    {
        return $this->redirect($this->generateUrl('chipset_search'));
    }

    /**
     * @Route("/{lang}/chipsets/{id}", requirements={"lang": "de|en|es|fr|it|nl|ro|ru"})
     */
    public function redirectLangChipsetShow($id)
    {
        return $this->redirect($this->generateUrl('chipset_show', array("id" => $id)));
    }

    /**
     * @Route("/{lang}/chipsets/index/{letter}", requirements={"lang": "de|en|es|fr|it|nl|ro|ru", "letter"="\w"}), methods={"GET"})
     * @param Request $request
     */
    public function redirectLangChipsetIndex(Request $request, string $letter)
    {
        return $this->redirect($this->generateUrl('chipsetindex', array_merge(
            $request->query->all(),
            array("letter" => $letter)
        )));
    }
}
