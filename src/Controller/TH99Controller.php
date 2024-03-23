<?php

namespace App\Controller;

use App\Entity\MotherboardIdRedirection;
use App\Entity\StorageDeviceIdRedirection;
use App\Repository\ExpansionCardIdRedirectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
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
                'No motherboard found for TH99 id: ' . $id
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
                'No harddrive found for TH99 id: ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('storage_show', array("id" => $idRedirection)));
        }
    }
    #[Route('/th99/r/{id}', name:'th99_cddrive', requirements:['id' => '\d+'])]
    public function cddrive(int $id, StorageDeviceIdRedirectionRepository $storageDeviceIdRedirectionRepository): Response
    {
        $idRedirection = $storageDeviceIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No optical drive found for TH99 id: ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('storage_show', array("id" => $idRedirection)));
        }
    }

    #[Route('/th99/p/{id}', name:'th99_tapedrive', requirements:['id' => '\d+'])]
    public function tapedrive(int $id, StorageDeviceIdRedirectionRepository $storageDeviceIdRedirectionRepository): Response
    {
        $idRedirection = $storageDeviceIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No tape drive found for TH99 id: ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('storage_show', array("id" => $idRedirection)));
        }
    }

    #[Route('/th99/c/{id}', name:'th99_card_controller', requirements:['id' => '\d+'])]
    public function cardController(int $id, ExpansionCardIdRedirectionRepository $expansionCardIdRedirectionRepository): Response
    {
        $idRedirection = $expansionCardIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No expansion card found for TH99 id: ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('expansioncard_show', array("id" => $idRedirection)));
        }
    }

    #[Route('/th99/v/{id}', name:'th99_card_video', requirements:['id' => '\d+'])]
    public function cardVideo(int $id, ExpansionCardIdRedirectionRepository $expansionCardIdRedirectionRepository): Response
    {
        $idRedirection = $expansionCardIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No expansion card found for TH99 id: ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('expansioncard_show', array("id" => $idRedirection)));
        }
    }

    #[Route('/th99/n/{id}', name:'th99_card_network', requirements:['id' => '\d+'])]
    public function cardNetwork(int $id, ExpansionCardIdRedirectionRepository $expansionCardIdRedirectionRepository): Response
    {
        $idRedirection = $expansionCardIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No expansion card found for TH99 id: ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('expansioncard_show', array("id" => $idRedirection)));
        }
    }

    #[Route('/th99/t/{id}', name:'th99_card_modem', requirements:['id' => '\d+'])]
    public function cardModem(int $id, ExpansionCardIdRedirectionRepository $expansionCardIdRedirectionRepository): Response
    {
        $idRedirection = $expansionCardIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No expansion card found for TH99 id: ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('expansioncard_show', array("id" => $idRedirection)));
        }
    }

    #[Route('/th99/i/{id}', name:'th99_card_other', requirements:['id' => '\d+'])]
    public function cardOther(int $id, ExpansionCardIdRedirectionRepository $expansionCardIdRedirectionRepository): Response
    {
        $idRedirection = $expansionCardIdRedirectionRepository->findRedirection($id, 'th99');

        if (!$idRedirection) {
            throw $this->createNotFoundException(
                'No expansion card found for TH99 id: ' . $id
            );
        } else {
            return $this->redirect($this->generateUrl('expansioncard_show', array("id" => $idRedirection)));
        }
    }
}
