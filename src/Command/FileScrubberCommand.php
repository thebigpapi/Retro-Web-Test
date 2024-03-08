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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

#[AsCommand(
    name: 'app:file-scrubber',
    description: 'Add a short description for your command',
)]
class FileScrubberCommand extends Command
{

    private int $filesToUpdate = 0;
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

        $io->success("Done scrubbing files");

        return Command::SUCCESS;
    }

    private function checkBioses(EntityRepository $entityRepository, SymfonyStyle $io) {
        $bioses = $entityRepository->findAll();

        foreach ($bioses as $bios) {
            $this->checkBios($bios, $io, $this->entityManagerInterface);
            if ($this->filesToUpdate > $this::FILES_TO_UPDATE_TRESHOLD) {
                $this->filesToUpdate = 0;
                $this->entityManagerInterface->flush();
            }
        }
        $this->entityManagerInterface->flush();
    }

    private function checkBios(MotherboardBios|ExpansionCardBios $bios, SymfonyStyle $io, EntityManagerInterface $entityManagerInterface) {
        if (($fileName = $bios->getFileName()) === null) {
            $io->warning($bios::class . " with id " . $bios->getId() . " has no file registered");
            return;
        }

        $mappings = $this->vichFactory->fromObject($bios);
        $pathPrefix = array_shift($mappings)->getUploadDestination();
        
        $filePath = implode('/', [$pathPrefix, $fileName]);

        if (!file_exists($filePath)) {
            $io->error($bios::class . " with id " . $bios->getId() . " has missing file. Database has filename " . $filePath . ", but no file was found for this path.");
            return;
        }

        $hash = hash_file('sha256', $filePath);

        if (($biosHash = $bios->getHash()) === null) {
            $io->warning($bios::class . " with id " . $bios->getId() . " had missing hash. Setting hash to " . $hash);
            $bios->setHash($hash);
            $entityManagerInterface->persist($bios);
            $this->filesToUpdate++;
            return;
        }

        if ($biosHash !== $hash) {
            $io->error($bios::class . " with id " . $bios->getId() . " has hash mismatch. Database has hash " . $biosHash . ", File has hash " . $hash);
        }

        $io->success($bios::class . " with id " . $bios->getId() . " is OK");
    }
}
