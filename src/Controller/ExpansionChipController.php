<?php

namespace App\Controller;

use App\Repository\ExpansionChipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpansionChipController extends AbstractController
{
    #[Route('/expansion-chips/{id}', name: 'expansion_chip_show', requirements: ['id' => '\d+'])]
    public function show(int $id, ExpansionChipRepository $expansionChipRepository): Response
    {
        $expansionChip = $expansionChipRepository->find($id);
        if (!$expansionChip) {
            throw $this->createNotFoundException(
                'No expansion chip found for id ' . $id
            );
        } else {
            return $this->render('expansion_chip/show.html.twig', [
                'expansion_chip' => $expansionChip,
                'controller_name' => 'ExpansionChipController',
            ]);
        }

    }
}
