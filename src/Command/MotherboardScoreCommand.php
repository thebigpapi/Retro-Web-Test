<?php

namespace App\Command;

use App\Entity\Motherboard;
use App\Repository\MotherboardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

#[AsCommand(
    name: 'app:motherboard-score',
    description: 'Calculates score for all motherboards',
)]
class MotherboardScoreCommand extends Command
{

    private int $entitiesToUpdate = 0;
    private int $total = 0;
    private const ENTITIES_TO_UPDATE_TRESHOLD = 100;

    public function __construct(
        private MotherboardRepository $motherboardRepository,
        private PropertyMappingFactory $vichFactory,
        private EntityManagerInterface $entityManagerInterface
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->calculateScoreAll($this->motherboardRepository, $io);

        $io->success("Done calculating scores");

        return Command::SUCCESS;
    }

    private function CalculateScoreAll(MotherboardRepository $motherboardRepository, SymfonyStyle $io) {
        $motherboards = $motherboardRepository->findAll();
        $this->total = count($motherboards);
        $current = -1;
        $step = 0;

        foreach ($motherboards as $motherboard) {
            $this->calculateScore($motherboard, $this->entityManagerInterface);
            $step += 1;
            if((int)(($step / $this->total) * 100) > $current){
                $current += 1;
                $io->write($current . "%...");
            }
            //$io->writeln($motherboard->getId() . " AA");
            if ($this->entitiesToUpdate > $this::ENTITIES_TO_UPDATE_TRESHOLD) {
                $this->entitiesToUpdate = 0;
                $this->entityManagerInterface->flush();
            }
        }
        $this->entityManagerInterface->flush();
    }

    private function calculateScore(Motherboard $motherboard, EntityManagerInterface $entityManagerInterface) {
        $newScore = $motherboard->calculateScore();
        $oldScore = $motherboard->getScore();
        if ($oldScore != $newScore){
            $motherboard->setScore($newScore);
            $entityManagerInterface->persist($motherboard);
            $this->entitiesToUpdate++;
        }

    }
}
