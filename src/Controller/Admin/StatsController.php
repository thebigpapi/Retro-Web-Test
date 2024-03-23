<?php

namespace App\Controller\Admin;

use App\Repository\MotherboardRepository;
use App\Repository\ChipsetRepository;
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
    private MotherboardRepository $motherboardRepository;
    private ChipsetRepository $chipsetRepository;
    public function __construct(MotherboardRepository $motherboardRepository, ChipsetRepository $chipsetRepository, ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;
        $this->motherboardRepository = $motherboardRepository;
        $this->chipsetRepository = $chipsetRepository;
    }

    #[Route('/dashboard/stats', name: 'dashboard_stats')]
    public function index(): Response
    {
        return $this->render('admin/stats.html.twig', [
            'mobocount' => $this->motherboardRepository->getCount(),
            'boardChart' => $this->createBoardChart(),
            'socketChart' => $this->createSocketChart(),
            'chipsetChart' => $this->createChipsetChart(),
            'expansionChipChart' => $this->createChipChart(),
            'formFactorChart' => $this->createFormFactorChart(),
            'chipsetDocCountChart' => $this->createChipsetDocCountChart(),
        ]);
    }
    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();
        $assets->addWebpackEncoreEntry('app_ea');
        return $assets;
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('The Retro Web')
            ->setFaviconPath('build/icons/favicon.ico');
    }
    private function createFormFactorChart(): array
    {
        $formFactorCount = $this->motherboardRepository->getFormFactorCount();
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
        return $this->getData($newarray, 'ff');
    }
    private function createChipsetDocCountChart(): array
    {
        $chipsetDocCount = $this->chipsetRepository->getChipsetDocCount();
        $newarray = array();
        $newarray['No'] = $chipsetDocCount[0]['count'];
        $newarray['Yes'] = $this->chipsetRepository->getCount() - $newarray['No'];
        return $this->getData($newarray, 'doc');
    }
    private function createBoardChart(): array
    {
        $manufBoardCount = $this->motherboardRepository->getManufCount();
        return $this->getData(array_slice($manufBoardCount, 0, 90), 'board');
    }
    private function createSocketChart(): array
    {
        $boardSockCount = $this->motherboardRepository->getSocketCount();
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
        return $this->getData($newarray, 'socket');
    }
    private function createChipsetChart(): array
    {
        $manufBoardCount = $this->motherboardRepository->getChipsetCount();
        return $this->getData(array_slice($manufBoardCount, 0, 90), 'chipset');
    }
    private function createChipChart(): array
    {
        $manufBoardCount = $this->motherboardRepository->getExpChipCount();
        return $this->getData(array_slice($manufBoardCount, 0, 90), 'chip');
    }
    private function getData($array, $id): array
    {
        $result = array();
        $result[$id . 'keysId'] = json_encode(array_keys($array));
        $result[$id . 'valuesId'] = json_encode(array_values($array));
        return $result;
    }
}
