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
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

#[AsCommand(
    name: 'app:thumb-regen',
    description: 'Regenerates image thumbnails',
)]
class ThumbRegenCommand extends Command
{

    public function __construct(
        private MotherboardImageRepository $motherboardImageRepository,
        private ExpansionCardBiosRepository $expansionCardBiosRepository,
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
        $greetInput = new ArrayInput([
            'command' => 'liip:imagine:cache:resolve',
            '--filter'  => ['show_thumb'],
            'paths'    => $this->getAllThumbs(),
            '--force'  => true,
        ]);
        $returnCode = $this->getApplication()->doRun($greetInput, $output);
        return Command::SUCCESS;
    }
    private function getThumbs(EntityRepository $entityRepository) {
        return $entityRepository->findAllImages();
    }
    private function getAllThumbs(): array
    {
        $imgArray = [];
        $imgArray = array_merge($imgArray, $this->getThumbs($this->motherboardImageRepository));
        $imgArray = array_merge($imgArray, $this->getThumbs($this->expansionCardImageRepository));
        $imgArray = array_merge($imgArray, $this->getThumbs($this->chipImageRepository));
        $imgArray = array_merge($imgArray, $this->getThumbs($this->storageDeviceImageRepository));
        $imgArray = array_merge($imgArray, $this->getThumbs($this->entityImageRepository));
        return $imgArray;
    }
}
