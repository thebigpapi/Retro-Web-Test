<?php

namespace App\Command;

use App\Repository\ChipDocumentationRepository;
use App\Repository\ChipImageRepository;
use App\Repository\ChipsetDocumentationRepository;
use App\Repository\EntityDocumentationRepository;
use App\Repository\EntityImageRepository;
use App\Repository\ExpansionCardBiosRepository;
use App\Repository\ExpansionCardDocumentationRepository;
use App\Repository\ExpansionCardImageRepository;
use App\Repository\ManualRepository;
use App\Repository\MotherboardBiosRepository;
use App\Repository\MotherboardImageRepository;
use App\Repository\StorageDeviceDocumentationRepository;
use App\Repository\StorageDeviceImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

#[AsCommand(
    name: 'app:file-check',
    description: 'Checks file integrity for images, BIOSes and docs',
)]
class FileCheckerCommand extends Command
{

    public function __construct(
        private MotherboardBiosRepository $motherboardBiosRepository,
        private ExpansionCardBiosRepository $expansionCardBiosRepository,
        private MotherboardImageRepository $motherboardImageRepository,
        private ExpansionCardImageRepository $expansionCardImageRepository,
        private ChipImageRepository $chipImageRepository,
        private StorageDeviceImageRepository $storageDeviceImageRepository,
        private EntityImageRepository $entityImageRepository,
        private ManualRepository $manualRepository,
        private ExpansionCardDocumentationRepository $expansionCardDocumentationRepository,
        private StorageDeviceDocumentationRepository $storageDeviceDocumentationRepository,
        private ChipDocumentationRepository $chipDocumentationRepository,
        private ChipsetDocumentationRepository $chipsetDocumentationRepository,
        private EntityDocumentationRepository $entityDocumentationRepository,
        private PropertyMappingFactory $vichFactory,
        private EntityManagerInterface $entityManagerInterface
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        //bioses
        $this->checkEntities($this->motherboardBiosRepository, $io);
        $this->checkEntities($this->expansionCardBiosRepository, $io);
        //images
        $this->checkEntities($this->motherboardImageRepository, $io);
        $this->checkEntities($this->expansionCardImageRepository, $io);
        $this->checkEntities($this->chipImageRepository, $io);
        $this->checkEntities($this->storageDeviceImageRepository, $io);
        $this->checkEntities($this->entityImageRepository, $io);
        //docs
        $this->checkEntities($this->manualRepository, $io);
        $this->checkEntities($this->expansionCardDocumentationRepository, $io);
        $this->checkEntities($this->chipDocumentationRepository, $io);
        $this->checkEntities($this->chipsetDocumentationRepository, $io);
        $this->checkEntities($this->storageDeviceDocumentationRepository, $io);
        $this->checkEntities($this->entityDocumentationRepository, $io);

        $io->success("Done checking files");

        return Command::SUCCESS;
    }
    private function checkEntities(EntityRepository $entityRepository, SymfonyStyle $io) {
        $entities = $entityRepository->findAll();
        foreach ($entities as $entity) {
            $this->checkEntity($entity, $io);
        }
    }
    private function checkEntity($bios, SymfonyStyle $io) {
        $fileName = $bios->getFileName();
        if($fileName === null)
            return;
        $mappings = $this->vichFactory->fromObject($bios);
        $pathPrefix = array_shift($mappings)->getUploadDestination();
        $filePath = implode('/', [$pathPrefix, $fileName]);
        if (!file_exists($filePath)) {
            $io->writeln($bios::class . "\\" . $bios->getId() . " missing file on disk! (expected at " . $filePath . ")");
        }
    }
}
