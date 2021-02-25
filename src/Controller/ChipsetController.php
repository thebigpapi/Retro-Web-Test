<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Chipset;
use App\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChipsetController extends AbstractController
{
    /**
    * @Route("/chipset/getByManufacturer/{id}", name="chipset_array_manufacturer")
    */
    public function getByManufacturerId(int $id, TranslatorInterface $translator) {
        //retrieving the manufacturers the same way as in MotherboardController->search()
        $chipsetManufacturers = $this->getDoctrine()
            ->getRepository(Manufacturer::class)
            ->findAllChipsetManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("");
        array_unshift ($chipsetManufacturers, $unidentifiedMan);
        if(array_key_exists($id,$chipsetManufacturers))
            $manufacturer = $chipsetManufacturers[$id];
        else
            throw $this->createNotFoundException('This manufacturer doesn\'t have any chipsets');

        // retrieving the chipsets the same way as in MotherboardController->search()
        $chipsets = $this->getDoctrine()
            ->getRepository(Chipset::class)
            ->findAllMotherboardChipset();

        usort($chipsets, function ($a, $b)
            {
                if ($a->getFullReference() == $b->getFullReference()) {
                    return 0;
                }
                return ($a->getFullReference() < $b->getFullReference()) ? -1 : 1;
            }
        );

        $unidentifiedChip = new Chipset();
        $unidentifiedChip->setName("");
        array_unshift ($chipsets, $unidentifiedChip);

        /*$chipsets = $this->getDoctrine()
            ->getRepository(Chipset::class)
            ->findByManufacturer($manufacturer);*/
        $arr = array();

        // getting only the right chipsets
        $idUnidentified = -1;
        foreach ($chipsets as $key => $chipset) {
            if($chipset->getManufacturer() == $manufacturer) {
                if ($chipset->getFullReference() == " Unidentified ") {    
                    $idUnidentified = $key;
                }
                else {
                    $arr[$key] = $chipset->getFullReference();
                }
            }
        }
        $arr = array(null=>"*", $idUnidentified => $translator->trans("Not identified")) + $arr;
        return new Response(json_encode($arr,true));

    }

}