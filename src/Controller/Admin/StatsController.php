<?php

namespace App\Controller\Admin;

use App\Repository\MotherboardRepository;
use App\Repository\ChipsetRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    private function createBoardChart(): Chart
    {
        $manufBoardCount = $this->motherboardRepository->getManufCount();
        return $this->makeChart(array_slice($manufBoardCount, 0, 90), Chart::TYPE_BAR, 0.4);
    }
    private function createChipsetChart(): Chart
    {
        $manufBoardCount = $this->motherboardRepository->getChipsetCount();
        return $this->makeChart(array_slice($manufBoardCount, 0, 90), Chart::TYPE_BAR, 0.4);
    }
    private function createChipChart(): Chart
    {
        $manufBoardCount = $this->motherboardRepository->getExpChipCount();
        return $this->makeChart(array_slice($manufBoardCount, 0, 90), Chart::TYPE_BAR, 0.4);
    }
    private function createSocketChart(): Chart
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
        return $this->makeChart($newarray, Chart::TYPE_BAR, 0.4);
    }
    private function createFormFactorChart(): Chart
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
        return $this->makeChart($newarray, Chart::TYPE_BAR, 1);
    }
    private function createChipsetDocCountChart(): Chart{
        $chipsetDocCount = $this->chipsetRepository->getChipsetDocCount();
        $newarray = array();
        $newarray['No'] = $chipsetDocCount[0]['count'];
        $newarray['Yes'] = $this->chipsetRepository->getCount() - $newarray['No'];
        return $this->makeChart($newarray, Chart::TYPE_PIE, 2);
    }
    private function makeChart($array, $t, $r): Chart
    {
        $chart = $this->chartBuilder->createChart($t);
        $chart->setData([
            'labels'=> array_keys($array),
            'datasets' => [
                [
                    'label' => 'Board count',
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.9)',
                        'rgba(255, 159, 64, 0.9)',
                        'rgba(255, 205, 86, 0.9)',
                        'rgba(75, 192, 192, 0.9)',
                        'rgba(54, 162, 235, 0.9)',
                        'rgba(153, 102, 255, 0.9)',
                        'rgba(201, 203, 207, 0.9)'
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    'data' => array_values($array),
                ],
            ],
        ]);
        $chart->setOptions([
            'indexAxis'=> 'y',
            'aspectRatio' => $r,
        ]);
        return $chart;
    }
}
