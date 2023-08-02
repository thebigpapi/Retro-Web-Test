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
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/*use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;*/

class DashboardController extends AbstractDashboardController
{
    /*public function __construct(
        private ChartBuilderInterface $chartBuilder,
    ) {
    }*/

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        /*$chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);*/

        return $this->render('admin/dashboard.html.twig', [
            //'chart' => $chart,
        ]);
    }
    /*public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();
        $assets->addWebpackEncoreEntry('admin_app');
        return $assets;
    }*/
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('The Retro Web');
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
        yield MenuItem::linkToCrud('Logs', 'show/data.svg', Trace::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Users', 'admin/user.svg', User::class)->setPermission('ROLE_SUPER_ADMIN');
    }
}
