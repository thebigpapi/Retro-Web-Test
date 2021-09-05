<?php

namespace App\Controller;

use App\Entity\MotherboardIdRedirection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MotherboardIdRedirectionRepository;

class TH99Controller extends AbstractController
{

    /**
    * @Route("/th99/m/{id}", name="th99_motherboard", requirements={"id"="\d+"})
    */
    public function motherboard(int $id)
    {
        /** @var MotherboardIdRedirectionRepository */
        $moboIdRedirectionRepo = $this->getDoctrine()->getRepository(MotherboardIdRedirection::class);
        $idRedirection = $moboIdRedirectionRepo->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No $motherboard found for id ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('motherboard_show', array("id" => $idRedirection)));
        }
    }
}
