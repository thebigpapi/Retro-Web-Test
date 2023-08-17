<?php

namespace App\Controller\Admin;
use App\Entity\Motherboard;
use App\Entity\Chipset;
use App\Entity\LargeFile;
use App\Entity\Processor;
use App\Entity\Coprocessor;
use App\Entity\ProcessorPlatformType;
use App\Entity\InstructionSet;
use App\Entity\CpuSpeed;
use App\Entity\ChipsetPart;
use App\Entity\ExpansionChip;
use App\Entity\ExpansionChipType;
use App\Entity\CacheSize;
use App\Entity\MaxRam;
use App\Entity\DramType;
use App\Entity\CpuSocket;
use App\Entity\ExpansionSlot;
use App\Entity\IoPort;
use App\Entity\PSUConnector;
use App\Entity\OsFlag;
use App\Entity\MediaTypeFlag;
use App\Entity\FormFactor;
use App\Entity\Manufacturer;
use App\Entity\KnownIssue;
use App\Entity\Creditor;
use App\Entity\License;
use App\Entity\User;
use App\Entity\Trace;
use App\Repository\MotherboardRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use App\BranchLoader\GitLoader;

class DashboardController extends AbstractDashboardController
{
    private ChartBuilderInterface $chartBuilder;
    private MotherboardRepository $motherboardRepository;
    private GitLoader $git;
    public function __construct(MotherboardRepository $motherboardRepository, ChartBuilderInterface $chartBuilder, GitLoader $git)
    {
        $this->chartBuilder = $chartBuilder;
        $this->motherboardRepository = $motherboardRepository;
        $this->git = $git;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'collector' => $this->git,
            'mobocount' => $this->motherboardRepository->getCount(),
            'boardChart' => $this->createBoardChart(),
            'socketChart' => $this->createSocketChart(),
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
            ->setTitle('The Retro Web');
    }

    /**
     * @param UserInterface|User $user
     */
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->addMenuItems([
                MenuItem::linkToRoute('Settings', 'fas fa-user', 'admin_user_settings')
            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'home.svg');
        yield MenuItem::linkToUrl('Legacy page', 'edit.svg', $this->generateUrl('admin_index'))->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Main items');
        yield MenuItem::linkToCrud('Motherboards', 'show/motherboard.svg', Motherboard::class)->setDefaultSort(['lastEdited' => 'DESC']);
        yield MenuItem::linkToCrud('Chipsets', 'show/chipset.svg', Chipset::class);
        yield MenuItem::linkToCrud('Drivers', 'show/hardware.svg', LargeFile::class);
        yield MenuItem::section('Processors');
        yield MenuItem::linkToCrud('CPUs', 'show/cpu.svg', Processor::class);
        yield MenuItem::linkToCrud('NPUs', 'show/cpu.svg', Coprocessor::class);
        yield MenuItem::linkToCrud('Processor families', 'show/486.svg', ProcessorPlatformType::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Instruction sets', 'show/486.svg', InstructionSet::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Speeds', 'show/speed.svg', CpuSpeed::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Chips');
        yield MenuItem::linkToCrud('Chipset parts', 'show/chip.svg', ChipsetPart::class);
        yield MenuItem::linkToCrud('Expansion chips', 'show/chip.svg', ExpansionChip::class);
        yield MenuItem::linkToCrud('Expansion chip types', 'show/chip.svg', ExpansionChipType::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Memory')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Cache size', 'show/chip.svg', CacheSize::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('RAM size', 'show/ram_multi.svg', MaxRam::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('RAM type', 'admin/ram.svg', DramType::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Connectors')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Sockets', 'show/cpu_pins.svg', CpuSocket::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Expansion slots', 'show/card.svg', ExpansionSlot::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('I/O ports', 'admin/connector.svg', IoPort::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('PSU connectors', 'show/power.svg', PSUConnector::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Misc');
        yield MenuItem::linkToCrud('OS flags', 'os/1998win.svg', OsFlag::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Media types', 'admin/file.svg', MediaTypeFlag::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Form factors', 'show/dimension.svg', FormFactor::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Known Issues', 'admin/misc.svg', KnownIssue::class);
        yield MenuItem::linkToCrud('Manufacturers', 'show/motherboard.svg', Manufacturer::class);
        yield MenuItem::linkToCrud('Creditors', 'search/search_image.svg', Creditor::class);
        yield MenuItem::linkToCrud('Licenses', 'nav/book.svg', License::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Administrative');
        yield MenuItem::linkToRoute('Logs', 'show/data.svg','admin_logs');
        yield MenuItem::linkToCrud('Logs (experimental)', 'show/data.svg', Trace::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Users', 'admin/user.svg', User::class)->setPermission('ROLE_SUPER_ADMIN');
    }

    private function createBoardChart(): Chart
    {
        $manufBoardCount = $this->motherboardRepository->getManufCount();
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels'=> array_keys(array_slice($manufBoardCount, 0, 30)),
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
                    'data' => array_values(array_slice($manufBoardCount, 0, 30)),
                ],
            ],
        ]);
        $chart->setOptions([
            'indexAxis'=> 'x',
        ]);
        return $chart;
    }
    private function createSocketChart(): Chart
    {
        $manufBoardCount = $this->motherboardRepository->getSocketCount();
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels'=> array_keys(array_slice($manufBoardCount, 0, 30)),
            'datasets' => [
                [
                    'label' => 'Socket count',
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
                    'data' => array_values(array_slice($manufBoardCount, 0, 30)),
                ],
            ],
        ]);
        $chart->setOptions([
            'indexAxis'=> 'x',
        ]);
        return $chart;
    }
}
