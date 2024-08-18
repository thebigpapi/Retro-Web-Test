<?php

namespace App\Command;

use App\Entity\CPUID;
use App\Entity\InstructionSet;
use App\Entity\ProcessorPlatformType;
use App\Entity\ProcessorVoltage;
use App\Repository\ProcessorPlatformTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:ppt-to-json',
    description: 'Generates JSON from the old CPU schema to chips (/!\ MUST BE RUN BEFORE THE MIGRATION /!\)',
)]
class ProcessorPlatformTypeJsonCommand extends Command
{
    public function __construct(
        private ProcessorPlatformTypeRepository $processorPlatformTypeRepository,
        private EntityManagerInterface $entityManagerInterface
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        $ppts = $this->processorPlatformTypeRepository->findAll();

        foreach($ppts as $ppt) {
            $this->toJson($ppt);
        }

        $this->entityManagerInterface->flush();

        $io->writeln("Updated " . count($ppts) . " platforms");

        
        return Command::SUCCESS;
    }

    protected function toJson(ProcessorPlatformType $ppt) {
        $json = [];
        $json["Microarchitecture"] = [];
        $json["Microarchitecture"]["CPUID"] = array_map(fn (CPUID $cpuId) => $cpuId->getValue(), $ppt->getCpuid()->toArray());
        $json["Microarchitecture"]["Features"] = array_map(fn (InstructionSet $instructionSet) => $instructionSet->getName(), $ppt->getInstructionSets()->toArray());

        $l1Value = "";
        if ($ppt->getL1code()) {
            $l1Value .= $ppt->getL1code()->getValueWithUnit();
        } else {
            $l1Value .= 'unknown';
        }
        $l1Value .= ' code, ';
        if ($ppt->getL1data()) {
            $l1Value .= $ppt->getL1data()->getValueWithUnit();
        } else {
            $l1Value .= 'unknown';
        }
        $l1Value .= " data";
        if ($ppt->getL1code() || $ppt->getL1data()) {
            $json["Microarchitecture"]["L1 cache"] = $l1Value;
        }
        

        $ppt->setMiscSpecs($json);

        $this->entityManagerInterface->persist($ppt);
    }
}
