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
            'boardChart' => $this->createBoardDashChart(),
            'socketChart' => $this->createSocketDashChart(),
        ]);
    }
    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();
        $assets->addWebpackEncoreEntry('app_ea');
        $assets->addHtmlContentToHead('<script type="module">import "/build/js/glightbox.min.js";const lightbox = GLightbox({});</script>');
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
        yield MenuItem::linkToCrud('Drivers', 'hardware.svg', LargeFile::class);
        yield MenuItem::linkToCrud('Chipsets', 'chipset.svg', Chipset::class);
        yield MenuItem::linkToCrud('Hard drives', 'hdd.svg', HardDrive::class);
        yield MenuItem::linkToCrud('CD drives', 'cd.svg', CdDrive::class);
        yield MenuItem::linkToCrud('Floppy drives', 'floppy.svg', FloppyDrive::class);
        yield MenuItem::section('Chips');
        yield MenuItem::linkToCrud('Expansion chips', 'chip.svg', ExpansionChip::class);
        yield MenuItem::linkToCrud('Expansion chip types', 'chip.svg', ExpansionChipType::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Processors');
        yield MenuItem::linkToCrud('CPUs', 'cpu.svg', Processor::class);
        yield MenuItem::linkToCrud('Processor families', '486.svg', ProcessorPlatformType::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Instruction sets', '486.svg', InstructionSet::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Speeds', 'speed.svg', CpuSpeed::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Memory')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Cache size', 'chip.svg', CacheSize::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('RAM size', 'ram_multi.svg', MaxRam::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('RAM type', 'ram.svg', DramType::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Storage')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Storage interface', 'cpu.svg', StorageDeviceInterface::class);
        yield MenuItem::linkToCrud('Storage size', 'cpu.svg', StorageDeviceSize::class);
        yield MenuItem::section('Connectors')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Sockets', 'cpupins.svg', CpuSocket::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Expansion slots', 'card.svg', ExpansionSlot::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('I/O ports', 'connector.svg', IoPort::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('PSU connectors', 'power.svg', PSUConnector::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Misc');
        yield MenuItem::linkToCrud('OS flags', 'os/1998win.svg', OsFlag::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Media types', 'file.svg', MediaTypeFlag::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Form factors', 'dimension.svg', FormFactor::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Known Issues', 'misc.svg', KnownIssue::class);
        yield MenuItem::linkToCrud('Manufacturers', 'board.svg', Manufacturer::class);
        yield MenuItem::linkToCrud('Creditors', 'search_image.svg', Creditor::class);
        yield MenuItem::linkToCrud('Licenses', 'book.svg', License::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Administrative');
        yield MenuItem::linkToRoute('Logs', 'data.svg','logs');
        //yield MenuItem::linkToCrud('Logs (experimental)', 'data.svg', Trace::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Users', 'user.svg', User::class)->setPermission('ROLE_SUPER_ADMIN');
    }

    private function createBoardDashChart(): array
    {
        $manufBoardCount = $this->motherboardRepository->getManufCount();
        return $this->getData(array_slice($manufBoardCount, 0, 25), 1, 'board');
    }
    private function createSocketDashChart(): array
    {
        $boardSockCount = $this->motherboardRepository->getSocketCount();
        return $this->getData(array_slice($boardSockCount, 0, 25), 1, 'socket');
    }
    private function getData($array, $r, $id): array
    {
        $result = array();
        $result[$id . 'keysId'] = json_encode(array_keys($array));
        $result[$id . 'valuesId'] = json_encode(array_values($array));
        return $result;
    }
}
