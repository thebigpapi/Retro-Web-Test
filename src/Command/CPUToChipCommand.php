<?php

namespace App\Command;

use App\Entity\Processor;
use App\Repository\ProcessorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:cpu-to-chip',
    description: 'Generates JSON from the old CPU schema to chips (/!\ MUST BE RUN BEFORE THE MIGRATION /!\)',
)]
class CPUToChipCommand extends Command
{
    public function __construct(
        private ProcessorRepository $processorRepository,
        private EntityManagerInterface $entityManagerInterface
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        $processors = $this->processorRepository->findAll();

        foreach($processors as $processor) {
            $this->toJson($processor);
        }

        $this->entityManagerInterface->flush();

        $io->writeln("Updated " . count($processors) . " processors");

        
        return Command::SUCCESS;
    }

    protected function toJson(Processor $processor) {
        $json = [];
        $json["Microarchitecture"] = [];
        $json["Power"] = [];
        $json["Microarchitecture"]["Core"] = $processor->getCore();
        $json["Microarchitecture"]["Speed"] = $processor->getSpeed()?->getValueWithUnit();
        if ($processor->getSpeed() && $processor->getFsb()) {
            //Adapting the multiplier to the closest plausible value (may not always be satisfying)
            $value = round($processor->getSpeed()->getValue() / $processor->getFsb()->getValue(), 1);
            $flooredValue = floor($value);
            if ($value < ($flooredValue + 0.2)) {
                $value = $flooredValue;
            } elseif ($value < ($flooredValue + 0.4)){
                $value = $flooredValue + 0.25;
            } elseif ($value < ($flooredValue + 0.6)) {
                $value = $flooredValue + 0.5;
            } elseif ($value < ($flooredValue + 0.8)) {
                $value = $flooredValue + 0.75;
            } else {
                $value = $flooredValue + 1;
            }
            $json["Microarchitecture"]["Multiplier"] = $value;
        }
        $json["Microarchitecture"]["Bus speed"] = $processor->getFsb()?->getValueWithUnit();
        $json["Microarchitecture"]["Core count"] = $processor->getCores();
        $json["Microarchitecture"]["Thread count"] = $processor->getThreads();
        if ($processor->getL2() && $processor->isL2shared()) {
            $json["Microarchitecture"]["L2 cache"] = $processor->getL2()->getValueWithUnit() . ' shared';
        } elseif ($processor->getL2() && $processor->getCores()) {
            $json["Microarchitecture"]["L2 cache"] = $processor?->getCores() . ' x ' . $processor->getL2()?->getValueWithUnit();
        } else {
            $json["Microarchitecture"]["L2 cache"] = $processor->getL2()?->getValueWithUnit();
        }
        if ($processor->getL3() && $processor->isL3shared()) {
            $json["Microarchitecture"]["L3 cache"] = $processor->getL3()->getValueWithUnit() . ' shared';
        } elseif ($processor->getL3() && $processor->getCores()) {
            $json["Microarchitecture"]["L3 cache"] = $processor->getCores() . ' x ' . $processor->getL3()->getValueWithUnit();
        } else {
            $json["Microarchitecture"]["L3 cache"] = $processor->getL3()?->getValueWithUnit();
        }

        $json["Power"]["Voltage"] = $processor->getVoltagesWithValue();

        $processor->setMiscSpecs($json);

        $this->entityManagerInterface->persist($processor);
    }
}
