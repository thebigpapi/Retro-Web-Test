<?php

namespace App\Controller;

use App\Entity\MotherboardIdRedirection;
use App\Entity\StorageDeviceIdRedirection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MotherboardIdRedirectionRepository;
use App\Repository\StorageDeviceIdRedirectionRepository;
use Symfony\Component\HttpFoundation\Response;

class TH99Controller extends AbstractController
{
    #[Route('/th99/m/{id}', name:'th99_motherboard', requirements:['id' => '\d+'])]
    public function motherboard(int $id, MotherboardIdRedirectionRepository $motherboardIdRedirectionRepository): Response
    {
        $idRedirection = $motherboardIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No $motherboard found for id ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('motherboard_show', array("id" => $idRedirection)));
        }
    }

    #[Route('/th99/h/{id}', name:'th99_harddrive', requirements:['id' => '\d+'])]
    public function harddrive(int $id, StorageDeviceIdRedirectionRepository $storageDeviceIdRedirectionRepository): Response
    {
        $idRedirection = $storageDeviceIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No $harddrive found for id ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('hard_drive_show', array("id" => $idRedirection)));
        }
    }

    #[Route('/th99/r/{id}', name:'th99_harddrive', requirements:['id' => '\d+'])]
    public function cddrive(int $id, StorageDeviceIdRedirectionRepository $storageDeviceIdRedirectionRepository): Response
    {
        $idRedirection = $storageDeviceIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No $optical drive found for id ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('cd_drive_show', array("id" => $idRedirection)));
        }
    }
}
