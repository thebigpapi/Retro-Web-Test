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


        }
        return $this->render('bios/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}