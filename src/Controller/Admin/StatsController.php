<?php

namespace App\Controller\Admin;

use App\Repository\ChipRepository;
use App\Repository\MotherboardRepository;
use App\Repository\ChipsetRepository;
use App\Repository\ExpansionCardRepository;
use DirectoryIterator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class StatsController extends AbstractDashboardController
{
    private ChartBuilderInterface $chartBuilder;
    public function __construct(ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;
    }

    #[Route('/dashboard/stats/boards', name: 'dashboard_stats_boards')]
    public function boardStats(MotherboardRepository $motherboardRepository): Response
    {
        return $this->render('admin/stats/boards.html.twig', [
            'mobocount' => $motherboardRepository->getCount(),
            'manufacturerChart' => $this->createBoardManufChart($motherboardRepository),
            'socketChart' => $this->createBoardSocketChart($motherboardRepository),
            'chipsetChart' => $this->createBoardChipsetChart($motherboardRepository),
            'expansionChipChart' => $this->createBoardChipChart($motherboardRepository),
            'formFactorChart' => $this->createBoardFormFactorChart($motherboardRepository),
        ]);
    }

    #[Route('/dashboard/stats/expansioncards', name: 'dashboard_stats_cards')]
    public function cardStats(ExpansionCardRepository $expansionCardRepository): Response
    {
        return $this->render('admin/stats/cards.html.twig', [
            'cardcount' => $expansionCardRepository->getCount(),
            'manufacturerChart' => $this->createCardManufChart($expansionCardRepository),
            'slotChart' => $this->createCardSlotChart($expansionCardRepository),
            'chipChart' => $this->createCardChipChart($expansionCardRepository),
            'typeChart' => $this->createCardTypeChart($expansionCardRepository),

        ]);
    }

    #[Route('/dashboard/stats/chip', name: 'dashboard_stats_chips')]
    public function chipStats(ChipRepository $chipRepository): Response
    {
        return $this->render('admin/stats/chips.html.twig', [
            'chipcount' => $chipRepository->getCount(),
            'manufacturerChart' => $this->createChipManufChart($chipRepository),
            'socketChart' => $this->createChipSocketChart($chipRepository),
            'typeChart' => $this->createChipTypeChart($chipRepository),

        ]);
    }

    #[Route('/dashboard/stats/chipset', name: 'dashboard_stats_chipsets')]
    public function chipsetStats(ChipsetRepository $chipsetRepository): Response
    {
        return $this->render('admin/stats/chipset.html.twig', [
            'chipsetcount' => $chipsetRepository->getCount(),
            'manufacturerChart' => $this->createChipsetManufChart($chipsetRepository),
            'chipsetDocCountChart' => $this->createChipsetDocCountChart($chipsetRepository),

        ]);
    }

    #[Route('/dashboard/stats/size', name: 'dashboard_stats_size')]
    public function storageStats(): Response
    {
        $sizeTree = array();

        $projectRootDir = $this->getParameter('kernel.project_dir') . '/public';
        $this->folderSize($projectRootDir, $sizeTree, $total);
        return $this->render('admin/stats/size.html.twig', [
            'boardTotal' => $this->convertSize($sizeTree[$projectRootDir . "/motherboard"] ?? 0),
            'chipTotal' => $this->convertSize($sizeTree[$projectRootDir . "/chip"] ?? 0),
            'cardTotal' => $this->convertSize($sizeTree[$projectRootDir . "/expansioncard"] ?? 0),
            'storTotal' => $this->convertSize($sizeTree[$projectRootDir . "/storage"] ?? 0),
            'driverTotal' => $this->convertSize($sizeTree[$projectRootDir . "/uploads"] ?? 0),
            'miscTotal' => $this->convertSize($sizeTree[$projectRootDir . "/misc"] ?? 0),
            'chipsetTotal' => $this->convertSize($sizeTree[$projectRootDir . "/chipset"] ?? 0),
            'total' => $this->convertSize($total),
            'boardStorage' => $this->createSizeBoardChart($sizeTree, $projectRootDir),
            'chipStorage' => $this->createSizeChipChart($sizeTree, $projectRootDir),
            'cardStorage' => $this->createSizeCardChart($sizeTree, $projectRootDir),
            'storStorage' => $this->createSizeStorageChart($sizeTree, $projectRootDir),
            'miscStorage' => $this->createSizeMiscChart($sizeTree, $projectRootDir),
        ]);
    }

    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();
        $assets->addWebpackEncoreEntry('admin');
        return $assets;
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('The Retro Web')
            ->setFaviconPath('build/icons/favicon.ico');
    }

    public function folderSize($dir, &$tree, &$total): int
    {
        $size = 0;
        $result = 0;
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            if(is_file($each)){
                $size += filesize($each);
            }
            else {
                $result += $this->folderSize($each, $tree, $total);
            }
        }
        $tree[$dir] = $size + $result;
        $total += $size;
        return $size;
    }

    public function convertSize(int $size): string
    {
        if ($size > pow(1024, 4)){
            return round($size / pow(1024, 4), 2) . " TiB";
        }
        if ($size > pow(1024, 3)){
            return round($size / pow(1024, 3), 2) . " GiB";
        }
        if ($size > pow(1024, 2)){
            return round($size / pow(1024, 2), 2) . " MiB";
        }
        if ($size > 1024){
            return round($size / 1024, 2) . " KiB";
        }
        return $size . " Bytes";
    }

    private function getData($array, $id): array
    {
        $result = array();
        $result[$id . 'keysId'] = json_encode(array_keys($array));
        $result[$id . 'valuesId'] = json_encode(array_values($array));
        return $result;
    }
    // board charts
    private function createBoardManufChart(MotherboardRepository $motherboardRepository): array
    {
        $manufBoardCount = $motherboardRepository->getManufCount();
        return $this->getData(array_slice($manufBoardCount, 0, 90), 'boardManuf');
    }
    private function createBoardSocketChart(MotherboardRepository $motherboardRepository): array
    {
        $boardSockCount = $motherboardRepository->getSocketCount();
        $newarray = array();
        $newarray['Other'] = 0;
        foreach(array_slice($boardSockCount, 0, 100) as $key => $value){
            if((int) $value >= 10)
                $newarray[$key] = (int) $value;
            else{
                $newarray['Other'] += (int) $value;
            }
        }
        $other = $newarray['Other'];
        unset($newarray['Other']);
        $newarray['Other'] = $other;
        return $this->getData($newarray, 'boardSocket');
    }
    private function createBoardChipsetChart(MotherboardRepository $motherboardRepository): array
    {
        $manufBoardCount = $motherboardRepository->getChipsetCount();
        return $this->getData(array_slice($manufBoardCount, 0, 90), 'boardChipset');
    }
    private function createBoardChipChart(MotherboardRepository $motherboardRepository): array
    {
        $manufBoardCount = $motherboardRepository->getChipCount();
        return $this->getData(array_slice($manufBoardCount, 0, 90), 'boardChip');
    }
    private function createBoardFormFactorChart(MotherboardRepository $motherboardRepository): array
    {
        $formFactorCount = $motherboardRepository->getFormFactorCount();
        $newarray = array();
        $newarray['Other'] = 0;
        foreach($formFactorCount as $key => $value){
            if((int) $value >= 25)
                $newarray[$key] = (int) $value;
            else{
                $newarray['Other'] += (int) $value;
            }
        }
        $other = $newarray['Other'];
        unset($newarray['Other']);
        $newarray['Other'] = $other;
        return $this->getData($newarray, 'boardFF');
    }
    //expansion cards
    private function createCardManufChart(ExpansionCardRepository $expansionCardRepository): array
    {
        $manufCardCount = $expansionCardRepository->getManufCount();
        return $this->getData(array_slice($manufCardCount, 0, 90), 'cardManuf');
    }
    private function createCardSlotChart(ExpansionCardRepository $expansionCardRepository): array
    {
        $cardSlotCount = $expansionCardRepository->getSlotCount();
        $newarray = array();
        foreach(array_slice($cardSlotCount, 0, 100) as $key => $value){
            $newarray[$key] = (int) $value;
        }
        return $this->getData($newarray, 'cardSlot');
    }
    private function createCardChipChart(ExpansionCardRepository $expansionCardRepository): array
    {
        $cardChipCount = $expansionCardRepository->getChipCount();
        return $this->getData(array_slice($cardChipCount, 0, 90), 'cardChip');
    }
    private function createCardTypeChart(ExpansionCardRepository $expansionCardRepository): array
    {
        $cardTypeCount = $expansionCardRepository->getTypeCount();
        $newarray = array();
        foreach($cardTypeCount as $key => $value){
            $newarray[$key] = (int) $value;
        }
        return $this->getData($newarray, 'cardType');
    }
    //chip charts
    private function createChipManufChart(ChipRepository $chipRepository): array
    {
        $chipManufCount = $chipRepository->getManufCount();
        return $this->getData(array_slice($chipManufCount, 0, 90), 'chipManuf');
    }
    private function createChipSocketChart(ChipRepository $chipRepository): array
    {
        $chipSockCount = $chipRepository->getSocketCount();
        $newarray = array();
        $newarray['Other'] = 0;
        foreach(array_slice($chipSockCount, 0, 100) as $key => $value){
            if((int) $value >= 10)
                $newarray[$key] = (int) $value;
            else{
                $newarray['Other'] += (int) $value;
            }
        }
        $other = $newarray['Other'];
        unset($newarray['Other']);
        $newarray['Other'] = $other;
        return $this->getData($newarray, 'chipSocket');
    }
    private function createChipTypeChart(ChipRepository $chipRepository): array
    {
        $chipTypeCount = $chipRepository->getTypeCount();
        $newarray = array();
        foreach(array_slice($chipTypeCount, 0, 100) as $key => $value){
            $newarray[$key] = (int) $value;
        }
        return $this->getData($newarray, 'chipType');
    }
    //chipset charts
    private function createChipsetManufChart(ChipsetRepository $chipsetRepository): array
    {
        $chipsetManufCount = $chipsetRepository->getManufCount();
        return $this->getData(array_slice($chipsetManufCount, 0, 90), 'chipsetManuf');
    }
    private function createChipsetDocCountChart(ChipsetRepository $chipsetRepository): array
    {
        $chipsetDocCount = $chipsetRepository->getChipsetDocCount();
        $newarray = array();
        $newarray['No'] = $chipsetDocCount[0]['count'];
        $newarray['Yes'] = $chipsetRepository->getCount() - $newarray['No'];
        return $this->getData($newarray, 'chipsetDoc');
    }
    //storage size charts
    private function createSizeBoardChart(array $sizeTree, string $projectRootDir): array
    {
        $newarray = array();
        $newarray['Images'] = $sizeTree[$projectRootDir . "/motherboard/image"];
        $newarray['BIOSes'] = $sizeTree[$projectRootDir . "/motherboard/bios"];
        $newarray['Manuals'] = $sizeTree[$projectRootDir . "/motherboard/manual"];
        $newarray['Misc files'] = $sizeTree[$projectRootDir . "/motherboard/miscfile"];
        return $this->getData($newarray, 'sizeBoard');
    }
    private function createSizeChipChart(array $sizeTree, string $projectRootDir): array
    {
        $newarray = array();
        $newarray['Images'] = $sizeTree[$projectRootDir . "/chip/image"];
        $newarray['BIOSes'] = $sizeTree[$projectRootDir . "/chip/bios"];
        $newarray['Documentation'] = $sizeTree[$projectRootDir . "/chip/documentation"];
        return $this->getData($newarray, 'sizeChip');
    }
    private function createSizeCardChart(array $sizeTree, string $projectRootDir): array
    {
        $newarray = array();
        $newarray['Images'] = $sizeTree[$projectRootDir . "/expansioncard/image"];
        $newarray['BIOSes'] = $sizeTree[$projectRootDir . "/expansioncard/bios"];
        $newarray['Documentation'] = $sizeTree[$projectRootDir . "/expansioncard/documentation"];
        return $this->getData($newarray, 'sizeCard');
    }
    private function createSizeStorageChart(array $sizeTree, string $projectRootDir): array
    {
        $newarray = array();
        $newarray['Images'] = $sizeTree[$projectRootDir . "/storage/image"];
        $newarray['Audio'] = $sizeTree[$projectRootDir . "/storage/audiofile"];
        $newarray['Documentation'] = $sizeTree[$projectRootDir . "/storage/documentation"];
        $newarray['Misc files'] = $sizeTree[$projectRootDir . "/storage/miscfile"];
        return $this->getData($newarray, 'sizeStorage');
    }
    private function createSizeMiscChart(array $sizeTree, string $projectRootDir): array
    {
        $newarray = array();
        $newarray['Images'] = $sizeTree[$projectRootDir . "/misc/image"];
        $newarray['Documentation'] = $sizeTree[$projectRootDir . "/misc/documentation"];
        return $this->getData($newarray, 'sizeMisc');
    }
}
