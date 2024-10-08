<?php

namespace App\Controller\Admin;
use App\Entity\Motherboard;
use App\Entity\Chipset;
use App\Entity\LargeFile;
use App\Entity\ProcessorPlatformType;
use App\Entity\InstructionSet;
use App\Entity\CpuSpeed;
use App\Entity\HardDrive;
use App\Entity\CdDrive;
use App\Entity\FloppyDrive;
use App\Entity\Chip;
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
use App\Entity\FormFactor;
use App\Entity\Manufacturer;
use App\Entity\KnownIssue;
use App\Entity\Creditor;
use App\Entity\License;
use App\Entity\StorageDeviceInterface;
use App\Entity\StorageDeviceSize;
use App\Entity\StorageDeviceImage;
use App\Entity\StorageDeviceDocumentation;
use App\Entity\ExpansionSlotInterface;
use App\Entity\ExpansionSlotSignal;
use App\Entity\IoPortInterface;
use App\Entity\IoPortInterfaceSignal;
use App\Entity\IoPortSignal;
//use App\Entity\MemoryConnector;
use App\Entity\ExpansionSlotInterfaceSignal;
use App\Entity\MotherboardImage;
use App\Entity\MotherboardBios;
use App\Entity\Manual;
use App\Entity\ChipsetDocumentation;
use App\Entity\ChipDocumentation;
use App\Entity\ChipImage;
use App\Entity\ExpansionCardDocumentation;
use App\Entity\ExpansionCardImage;
use App\Entity\User;
use App\Repository\MotherboardRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use App\BranchLoader\GitLoader;
use App\Entity\ChipAlias;
use App\Entity\ChipsetAlias;
use App\Entity\EntityDocumentation;
use App\Entity\EntityImage;
use App\Entity\ExpansionCardAlias;
use App\Entity\ExpansionCardBios;
use App\Entity\FloppyDriveType;
use App\Entity\MotherboardAlias;
use App\Entity\OsArchitecture;
use App\Entity\StorageDeviceAlias;

class DashboardController extends AbstractDashboardController
{
    private MotherboardRepository $motherboardRepository;
    private GitLoader $git;
    public function __construct(MotherboardRepository $motherboardRepository, GitLoader $git)
    {
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
        yield MenuItem::subMenu('Statistics', 'data.svg')->setSubItems([
            MenuItem::linkToRoute('Motherboards', 'board.svg', 'dashboard_stats_boards')->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToRoute('Expansion cards', 'card.svg', 'dashboard_stats_cards')->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToRoute('Chips', 'chip.svg', 'dashboard_stats_chips')->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToRoute('Chipsets', 'chipset.svg', 'dashboard_stats_chipsets')->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToRoute('Size', 'dimension.svg', 'dashboard_stats_size')->setPermission('ROLE_MODERATOR')
        ])->setPermission('ROLE_MODERATOR');
        yield MenuItem::section('Main items')->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Motherboards', 'board.svg', Motherboard::class)->setDefaultSort(['lastEdited' => 'DESC'])->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Chips', 'chip.svg', Chip::class)->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Chipsets', 'chipset.svg', Chipset::class)->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Expansion cards', 'card.svg', ExpansionCard::class)->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Hard drives', 'hdd.svg', HardDrive::class)->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Optical drives', 'cd.svg', CdDrive::class)->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Floppy & tape drives', 'floppy.svg', FloppyDrive::class)->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Drivers', 'hardware.svg', LargeFile::class)->setPermission('ROLE_MODERATOR');
        yield MenuItem::section('Auxiliary items')->setPermission('ROLE_MODERATOR');
        yield MenuItem::subMenu('Motherboard related', 'board.svg')->setSubItems([
            MenuItem::linkToCrud('Form factors', 'dimension.svg', FormFactor::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Expansion slots', 'card.svg', ExpansionSlot::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('I/O ports', 'rs232.svg', IoPort::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::section('Advanced'),
            MenuItem::linkToCrud('Aliases', 'board_alias.svg', MotherboardAlias::class)->setController(MotherboardAliasCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Images', 'search_image.svg', MotherboardImage::class)->setController(MotherboardImageCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('BIOSes', 'awchip.svg', MotherboardBios::class)->setController(MotherboardBiosCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Manuals', 'manual.svg', Manual::class)->setController(ManualCrudController::class)->setPermission('ROLE_MODERATOR'),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Chip related', 'chip.svg')->setSubItems([
            MenuItem::linkToCrud('Chip types', 'chip_alias.svg', ExpansionChipType::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Families', '486.svg', ProcessorPlatformType::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Features', 'cpu.svg', InstructionSet::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Sockets', 'socket.svg', CpuSocket::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Speeds', 'speed.svg', CpuSpeed::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::section('Advanced'),
            MenuItem::linkToCrud('Chip aliases', 'chip_alias.svg', ChipAlias::class)->setController(ChipAliasCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Chip images', 'search_image.svg', ChipImage::class)->setController(ChipImageCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Chip docs', 'manual.svg', ChipDocumentation::class)->setController(ChipDocumentationCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Chipset aliases', 'chip_alias.svg', ChipsetAlias::class)->setController(ChipsetAliasCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Chipset docs', 'manual.svg', ChipsetDocumentation::class)->setController(ChipsetDocumentationCrudController::class)->setPermission('ROLE_MODERATOR'),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Expansion card related', 'card.svg')->setSubItems([
            MenuItem::linkToCrud('Types', 'tag.svg', ExpansionCardType::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::section('Advanced'),
            MenuItem::linkToCrud('Aliases', 'tag.svg', ExpansionCardAlias::class)->setController(ExpansionCardAliasCrudController::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Images', 'search_image.svg', ExpansionCardImage::class)->setController(ExpansionCardImageCrudController::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('BIOSes', 'awchip.svg', ExpansionCardBios::class)->setController(ExpansionCardBiosCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Documentation', 'manual.svg', ExpansionCardDocumentation::class)->setController(ExpansionCardDocumentationCrudController::class)->setPermission('ROLE_ADMIN'),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Storage related', 'hdd.svg')->setSubItems([
            MenuItem::linkToCrud('Interface', 'io.svg', StorageDeviceInterface::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Physical size', 'dimension.svg', StorageDeviceSize::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Floppy drive type', 'floppy.svg', FloppyDriveType::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::section('Advanced'),
            MenuItem::linkToCrud('Aliases', 'tag.svg', StorageDeviceAlias::class)->setController(StorageDeviceAliasCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Images', 'search_image.svg', StorageDeviceImage::class)->setController(StorageDeviceImageCrudController::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Documentation', 'manual.svg', StorageDeviceDocumentation::class)->setController(StorageDeviceDocumentationCrudController::class)->setPermission('ROLE_MODERATOR'),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Driver related', 'hardware.svg')->setSubItems([
            MenuItem::linkToCrud('OS flags', '1998win.svg', OsFlag::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('OS architectures', '486.svg', OsArchitecture::class)->setPermission('ROLE_MODERATOR'),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Connectors', 'rs232.svg')->setSubItems([
            MenuItem::linkToCrud('Power connectors', 'power.svg', PSUConnector::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('I/O ports', 'rs232.svg', IoPortInterfaceSignal::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('I/O port connectors', 'connector.svg', IoPortInterface::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('I/O port signals', 'rs232_electric.svg', IoPortSignal::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Expansion slots', 'exp_slot.svg', ExpansionSlotInterfaceSignal::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Expansion slot connectors', 'pci_slot_smol.svg', ExpansionSlotInterface::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Expansion slot signals', 'pci_slot_electric.svg', ExpansionSlotSignal::class)->setPermission('ROLE_ADMIN'),
        ])->setPermission('ROLE_MODERATOR');
        yield MenuItem::subMenu('Memory related', 'ram.svg')->setSubItems([
            //MenuItem::linkToCrud('Memory connectors', 'ram.svg', MemoryConnector::class),
            MenuItem::linkToCrud('Cache size', 'chip.svg', CacheSize::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('RAM size', 'ram_multi.svg', MaxRam::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('RAM type', 'ram.svg', DramType::class)->setPermission('ROLE_MODERATOR'),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Misc', 'misc.svg')->setSubItems([
            MenuItem::linkToCrud('Manufacturers', 'factory.svg', Manufacturer::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Known Issues', 'misc.svg', KnownIssue::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Creditors', 'creditor.svg', Creditor::class)->setPermission('ROLE_MODERATOR'),
            MenuItem::linkToCrud('Licenses', 'license.svg', License::class)->setPermission('ROLE_ADMIN'),
            MenuItem::section('Advanced')->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Entity images', 'search_image.svg', EntityImage::class)->setController(EntityImageCrudController::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Entity docs', 'manual.svg', EntityDocumentation::class)->setController(EntityDocumentationCrudController::class)->setPermission('ROLE_ADMIN'),
        ])->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToUrl('Logs', 'data.svg',"/audit")->setPermission('ROLE_MODERATOR');
        yield MenuItem::linkToCrud('Users', 'user.svg', User::class)->setPermission('ROLE_SUPER_ADMIN');
    }

    private function createBoardDashChart(): array
    {
        $manufBoardCount = $this->motherboardRepository->getManufCount();
        return $this->getData(array_slice($manufBoardCount, 0, 25), 'boardManuf');
    }
    private function createSocketDashChart(): array
    {
        $boardSockCount = $this->motherboardRepository->getSocketCount();
        return $this->getData(array_slice($boardSockCount, 0, 25), 'boardSocket');
    }
    private function getData($array, $id): array
    {
        $result = array();
        $result[$id . 'keysId'] = json_encode(array_keys($array));
        $result[$id . 'valuesId'] = json_encode(array_values($array));
        return $result;
    }
}
