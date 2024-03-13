<?php

namespace App\Command;

use App\Entity\ExpansionCardBios;
use App\Entity\MotherboardBios;
use App\Repository\ExpansionCardBiosRepository;
use App\Repository\MotherboardBiosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

#[AsCommand(
    name: 'app:hash-check',
    description: 'Hashes BIOS files',
)]
class FileHasherCommand extends Command
{

    private int $filesToUpdate = 0;
    private int $total = 0;
    private const FILES_TO_UPDATE_TRESHOLD = 100;

    public function __construct(
        private MotherboardBiosRepository $motherboardBiosRepository,
        private ExpansionCardBiosRepository $expansionCardBiosRepository,
        private PropertyMappingFactory $vichFactory,
        private EntityManagerInterface $entityManagerInterface
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->checkBioses($this->motherboardBiosRepository, $io);
        $this->checkBioses($this->expansionCardBiosRepository, $io);

        $io->success("Done hashing files");

        return Command::SUCCESS;
    }

    private function checkBioses(EntityRepository $entityRepository, SymfonyStyle $io) {
        $bioses = $entityRepository->findAll();
        $this->total = count($bioses);
        $current = -1;
        $step = 0;

        foreach ($bioses as $bios) {
            $this->checkBios($bios, $io, $this->entityManagerInterface);
            $step += 1;
            if((int)(($step / $this->total) * 100) > $current){
                $current += 1;
                $io->write($current . "%...");
            }
            if ($this->filesToUpdate > $this::FILES_TO_UPDATE_TRESHOLD) {
                $this->filesToUpdate = 0;
                $this->entityManagerInterface->flush();
            }
        }
        $this->entityManagerInterface->flush();
    }

    private function checkBios(MotherboardBios|ExpansionCardBios $bios, SymfonyStyle $io, EntityManagerInterface $entityManagerInterface) {
        $fileName = $bios->getFileName();
        if($fileName === null)
            return;
        $mappings = $this->vichFactory->fromObject($bios);
        $pathPrefix = array_shift($mappings)->getUploadDestination();
        $filePath = implode('/', [$pathPrefix, $fileName]);

        if (!file_exists($filePath)) {
            $io->writeln($bios::class . "\\" . $bios->getId() . " missing file on disk! (expected at " . $filePath . ")");
            return;
        }
        $hash = hash_file('sha256', $filePath);
        if (($biosHash = $bios->getHash()) === null) {
            $bios->setHash($hash);
            $entityManagerInterface->persist($bios);
            $this->filesToUpdate++;
            return;
        }
        if ($biosHash !== $hash) {
            $io->writeln($bios::class . "\\" . $bios->getId() . " hash mismatch!\nExpected: " . $biosHash . "\nActual: " . $hash);
        }
    }
}
