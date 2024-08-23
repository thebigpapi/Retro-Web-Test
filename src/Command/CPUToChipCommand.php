<?php

namespace App\Command;

use App\Entity\Processor;
//use App\Repository\ProcessorRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
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
        //private ProcessorRepository $processorRepository,
        private EntityManagerInterface $entityManagerInterface
    )
    {
        parent::__construct();
    }

    /*protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        $processors = $this->processorRepository->findAll();

        foreach($processors as $processor) {
            $this->toJson($processor, $io);
        }

        $this->entityManagerInterface->flush();

        $io->writeln("Updated " . count($processors) . " processors");

        return Command::SUCCESS;
    }

    protected function toJson(Processor $processor, SymfonyStyle $io) {
        $quadfsb = [400, 533, 667, 1066, 1333, 1600];
        $doublefsb = [200, 266, 333, 400];
        $htfsb = [800, 1000, 1800, 2000, 2200, 2400];
        $json = [];
        $json["Microarchitecture"] = [];
        $json["Power"] = [];
        $json["Microarchitecture"]["Core"] = $processor->getCore();
        $json["Microarchitecture"]["Frequency"] = $processor->getSpeed()?->getValueWithUnit();
        $json["Microarchitecture"]["Bus speed"] = $processor->getFsb()?->getValueWithUnit();
        if ($processor->getSpeed() && $processor->getFsb()) {
            $manufId = $processor->getManufacturer()->getId();
            $speed = $processor->getSpeed()->getValue();
            $commonFsb = $processor->getFsb()->getValue();
            if(in_array($commonFsb, $quadfsb)){
                $commonFsb = $commonFsb / 4;
            }
            if(in_array($commonFsb, $doublefsb)){
                $commonFsb = $commonFsb / 2;
            }
            //treating common fsbs between vendors
            if($manufId == 207){
                //intel
                if($commonFsb == 800){
                    $commonFsb = $commonFsb / 4;
                }
                if($commonFsb == 2400){ //QPI
                    $commonFsb = 133;
                }
                if($commonFsb == 2500){ //ivy
                    $commonFsb = 100;
                }
            }
            if($manufId == 27){
                //amd
                if(in_array($commonFsb, $htfsb)){
                    $commonFsb = 200;
                }
            }

            if($commonFsb == 33 && $speed > 100){
                $commonFsb = 0;
            }
            if($commonFsb != 0){
                $value = round($speed / $commonFsb, 1);
                $flooredValue = floor($value);
                if($value - floor($value) != 0.5 && $value - floor($value) != 0 && $value - floor($value) != 1){
                    $value = $value - 0.1;
                }
                if($value - floor($value) != 0.5 && $value - floor($value) != 0 && $value - floor($value) != 1){
                    $io->writeln($processor->getId() . " mul: " . $value . " freq" . $processor->getSpeed()->getValue() . " fsb" . $processor->getFsb()->getValue() . " manuf id " . $manufId);
                }
                $json["Microarchitecture"]["Multiplier"] = $value . 'x';
            }
        }
        $cores = $processor->getCores();
        if($cores > 1){
            $json["Microarchitecture"]["Core count"] = $cores;
            $json["Microarchitecture"]["Thread count"] = $processor->getThreads();
        }
        if ($processor->getL2() && $processor->isL2shared()) {
            $json["Microarchitecture"]["L2 cache"] = $processor->getL2()->getValueWithUnit() . ' shared';
        } elseif ($processor->getL2() && $processor->getCores()) {
            $json["Microarchitecture"]["L2 cache"] = $processor?->getCores() . ' x ' . $processor->getL2()?->getValueWithUnit();
        } else {
            if($processor->getL2()){
                $json["Microarchitecture"]["L2 cache"] = $processor->getL2()->getValueWithUnit();
            }
        }
        if ($processor->getL3() && $processor->isL3shared()) {
            $json["Microarchitecture"]["L3 cache"] = $processor->getL3()->getValueWithUnit() . ' shared';
        } elseif ($processor->getL3() && $processor->getCores()) {
            $json["Microarchitecture"]["L3 cache"] = $processor->getCores() . ' x ' . $processor->getL3()->getValueWithUnit();
        } else {
            if($processor->getL2()){
                $json["Microarchitecture"]["L3 cache"] = $processor->getL3()->getValueWithUnit();
            }
        }

        $json["Power"]["Voltage"] = $processor->getVoltagesWithValue();

        $processor->setMiscSpecs($json);

        $this->entityManagerInterface->persist($processor);
    }*/
}