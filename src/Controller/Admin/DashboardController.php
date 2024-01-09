<?php

namespace App\Controller\Admin;
use App\Entity\Motherboard;
use App\Entity\Chipset;
use App\Entity\LargeFile;
use App\Entity\Processor;
use App\Entity\ProcessorPlatformType;
use App\Entity\InstructionSet;
use App\Entity\CpuSpeed;
use App\Entity\HardDrive;
use App\Entity\CdDrive;
use App\Entity\FloppyDrive;
use App\Entity\ExpansionChip;
use App\Entity\ExpansionChipType;
use App\Entity\ExpansionCard;
use App\Entity\ExpansionCardType;
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
use App\Entity\StorageDeviceInterface;
use App\Entity\StorageDeviceSize;
use App\Entity\User;
use App\Repository\MotherboardRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use App\BranchLoader\GitLoader;
use App\Entity\MemoryConnector;

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
            'boardChart' => $this->createBoardDashChart(),
            'socketChart' => $this->createSocketDashChart(),
        ]);
    }
    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();
        $assets->addWebpackEncoreEntry('app_ea');
        $assets->addHtmlContentToHead('<script type="module">import "/build/js/glightbox.min.js";const lightbox = GLightbox({});</script>');
        $assets->addHtmlContentToHead('<script src="/build/js/show.js" defer></script>');
        $assets->addWebpackEncoreEntry('chart');
        $assets->addCssFile('/build/css/glightbox.min.css');
        return $assets;
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('The Retro Web')
            ->setFaviconPath('build/icons/favicon.ico');
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
        yield MenuItem::linkToRoute('Statistics', 'data.svg', 'dashboard_stats');
        yield MenuItem::section('Main items');
        yield MenuItem::linkToCrud('Motherboards', 'board.svg', Motherboard::class)->setDefaultSort(['lastEdited' => 'DESC']);
        yield MenuItem::linkToCrud('Chipsets', 'chipset.svg', Chipset::class);
        yield MenuItem::linkToCrud('Expansion cards', 'card.svg', ExpansionCard::class);
        yield MenuItem::linkToCrud('CPUs', '486.svg', Processor::class);
        yield MenuItem::linkToCrud('Drivers', 'hardware.svg', LargeFile::class);
        yield MenuItem::linkToCrud('Hard drives', 'hdd.svg', HardDrive::class);
        yield MenuItem::linkToCrud('Optical drives', 'cd.svg', CdDrive::class);
        yield MenuItem::linkToCrud('Floppy drives', 'floppy.svg', FloppyDrive::class);
        yield MenuItem::linkToCrud('Expansion chips', 'chip.svg', ExpansionChip::class);
        yield MenuItem::section('Auxiliary items');
        yield MenuItem::linkToCrud('Expansion card types', 'card.svg', ExpansionCardType::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Expansion chip types', 'chip_alias.svg', ExpansionChipType::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Storage related', 'hdd.svg')->setSubItems([
            MenuItem::linkToCrud('Interface', 'io.svg', StorageDeviceInterface::class),
            MenuItem::linkToCrud('Physical size', 'dimension.svg', StorageDeviceSize::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Memory related', 'ram.svg')->setSubItems([
            MenuItem::linkToCrud('Cache size', 'chip.svg', CacheSize::class),
            MenuItem::linkToCrud('RAM size', 'ram_multi.svg', MaxRam::class),
            MenuItem::linkToCrud('RAM type', 'ram.svg', DramType::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('CPU related', 'cpu.svg')->setSubItems([
            MenuItem::linkToCrud('CPU families', '486.svg', ProcessorPlatformType::class),
            MenuItem::linkToCrud('Instruction sets', '486.svg', InstructionSet::class),
            MenuItem::linkToCrud('Speeds', 'speed.svg', CpuSpeed::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Connectors', 'connector.svg')->setSubItems([
            MenuItem::linkToCrud('Sockets', 'cpupins.svg', CpuSocket::class),
            MenuItem::linkToCrud('Expansion slots', 'card.svg', ExpansionSlot::class),
            MenuItem::linkToCrud('I/O ports', 'rs232.svg', IoPort::class),
            MenuItem::linkToCrud('PSU connectors', 'power.svg', PSUConnector::class),
            MenuItem::linkToCrud('Memory connectors', 'ram.svg', MemoryConnector::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Misc', 'misc.svg')->setSubItems([
            MenuItem::linkToCrud('OS flags', 'os/1998win.svg', OsFlag::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Media types', 'file.svg', MediaTypeFlag::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Form factors', 'dimension.svg', FormFactor::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Known Issues', 'misc.svg', KnownIssue::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Manufacturers', 'factory.svg', Manufacturer::class),
            MenuItem::linkToCrud('Creditors', 'creditor.svg', Creditor::class),
            MenuItem::linkToCrud('Licenses', 'license.svg', License::class)->setPermission('ROLE_ADMIN'),
        ]);
        yield MenuItem::linkToUrl('Logs', 'data.svg',"/audit");
        yield MenuItem::linkToCrud('Users', 'user.svg', User::class)->setPermission('ROLE_SUPER_ADMIN');
    }

    private function createBoardDashChart(): array
    {
        $manufBoardCount = $this->motherboardRepository->getManufCount();
        return $this->getData(array_slice($manufBoardCount, 0, 25), 'board');
    }
    private function createSocketDashChart(): array
    {
        $boardSockCount = $this->motherboardRepository->getSocketCount();
        return $this->getData(array_slice($boardSockCount, 0, 25), 'socket');
    }
    private function getData($array, $id): array
    {
        $result = array();
        $result[$id . 'keysId'] = json_encode(array_keys($array));
        $result[$id . 'valuesId'] = json_encode(array_values($array));
        return $result;
    }
}
