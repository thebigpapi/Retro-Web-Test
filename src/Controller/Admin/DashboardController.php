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
        yield MenuItem::linkToRoute('Statistics', 'data.svg', 'dashboard_stats');
        yield MenuItem::section('Main items');
        yield MenuItem::linkToCrud('Motherboards', 'board.svg', Motherboard::class)->setDefaultSort(['lastEdited' => 'DESC']);
        yield MenuItem::linkToCrud('Chips', 'chip.svg', Chip::class);
        yield MenuItem::linkToCrud('Chipsets', 'chipset.svg', Chipset::class);
        yield MenuItem::linkToCrud('Expansion cards', 'card.svg', ExpansionCard::class);
        yield MenuItem::linkToCrud('Hard drives', 'hdd.svg', HardDrive::class);
        yield MenuItem::linkToCrud('Optical drives', 'cd.svg', CdDrive::class);
        yield MenuItem::linkToCrud('Floppy & tape drives', 'floppy.svg', FloppyDrive::class);
        yield MenuItem::linkToCrud('Drivers', 'hardware.svg', LargeFile::class);
        yield MenuItem::section('Auxiliary items');
        yield MenuItem::subMenu('Motherboard related', 'board.svg')->setSubItems([
            MenuItem::linkToCrud('Form factors', 'dimension.svg', FormFactor::class),
            MenuItem::linkToCrud('Expansion slots', 'card.svg', ExpansionSlot::class),
            MenuItem::linkToCrud('I/O ports', 'rs232.svg', IoPort::class),
            MenuItem::section('Advanced'),
            MenuItem::linkToCrud('Aliases', 'board_alias.svg', MotherboardAlias::class)->setController(MotherboardAliasCrudController::class),
            MenuItem::linkToCrud('Images', 'search_image.svg', MotherboardImage::class)->setController(MotherboardImageCrudController::class),
            MenuItem::linkToCrud('BIOSes', 'awchip.svg', MotherboardBios::class)->setController(MotherboardBiosCrudController::class),
            MenuItem::linkToCrud('Manuals', 'manual.svg', Manual::class)->setController(ManualCrudController::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Chip related', 'chip.svg')->setSubItems([
            MenuItem::linkToCrud('Chip types', 'chip_alias.svg', ExpansionChipType::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Families', '486.svg', ProcessorPlatformType::class),
            MenuItem::linkToCrud('Sockets', 'cpupins.svg', CpuSocket::class),
            MenuItem::linkToCrud('Speeds', 'speed.svg', CpuSpeed::class),
            MenuItem::section('Advanced'),
            MenuItem::linkToCrud('Chip aliases', 'chip_alias.svg', ChipAlias::class)->setController(ChipAliasCrudController::class),
            MenuItem::linkToCrud('Chip images', 'search_image.svg', ChipImage::class)->setController(ChipImageCrudController::class),
            MenuItem::linkToCrud('Chip docs', 'manual.svg', ChipDocumentation::class)->setController(ChipDocumentationCrudController::class),
            MenuItem::linkToCrud('Chipset aliases', 'chip_alias.svg', ChipsetAlias::class)->setController(ChipsetAliasCrudController::class),
            MenuItem::linkToCrud('Chipset docs', 'manual.svg', ChipsetDocumentation::class)->setController(ChipsetDocumentationCrudController::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Expansion card related', 'card.svg')->setSubItems([
            MenuItem::linkToCrud('Types', 'tag.svg', ExpansionCardType::class),
            MenuItem::section('Advanced'),
            MenuItem::linkToCrud('Aliases', 'tag.svg', ExpansionCardAlias::class)->setController(ExpansionCardAliasCrudController::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Images', 'search_image.svg', ExpansionCardImage::class)->setController(ExpansionCardImageCrudController::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('BIOSes', 'awchip.svg', ExpansionCardBios::class)->setController(ExpansionCardBiosCrudController::class),
            MenuItem::linkToCrud('Documentation', 'manual.svg', ExpansionCardDocumentation::class)->setController(ExpansionCardDocumentationCrudController::class)->setPermission('ROLE_ADMIN'),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Storage related', 'hdd.svg')->setSubItems([
            MenuItem::linkToCrud('Interface', 'io.svg', StorageDeviceInterface::class),
            MenuItem::linkToCrud('Physical size', 'dimension.svg', StorageDeviceSize::class),
            MenuItem::linkToCrud('Floppy drive type', 'floppy.svg', FloppyDriveType::class),
            MenuItem::section('Advanced'),
            MenuItem::linkToCrud('Aliases', 'tag.svg', StorageDeviceAlias::class)->setController(StorageDeviceAliasCrudController::class),
            MenuItem::linkToCrud('Images', 'search_image.svg', StorageDeviceImage::class)->setController(StorageDeviceImageCrudController::class),
            MenuItem::linkToCrud('Documentation', 'manual.svg', StorageDeviceDocumentation::class)->setController(StorageDeviceDocumentationCrudController::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Driver related', 'hardware.svg')->setSubItems([
            MenuItem::linkToCrud('OS flags', '1998win.svg', OsFlag::class),
            MenuItem::linkToCrud('OS architectures', '486.svg', OsArchitecture::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Connectors', 'rs232.svg')->setSubItems([
            MenuItem::linkToCrud('Power connectors', 'power.svg', PSUConnector::class),
            MenuItem::linkToCrud('I/O ports', 'rs232.svg', IoPortInterfaceSignal::class),
            MenuItem::linkToCrud('I/O port connectors', 'connector.svg', IoPortInterface::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('I/O port signals', 'rs232_electric.svg', IoPortSignal::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Expansion slots', 'exp_slot.svg', ExpansionSlotInterfaceSignal::class),
            MenuItem::linkToCrud('Expansion slot connectors', 'pci_slot_smol.svg', ExpansionSlotInterface::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Expansion slot signals', 'pci_slot_electric.svg', ExpansionSlotSignal::class)->setPermission('ROLE_ADMIN'),
        ]);
        yield MenuItem::subMenu('Memory related', 'ram.svg')->setSubItems([
            //MenuItem::linkToCrud('Memory connectors', 'ram.svg', MemoryConnector::class),
            MenuItem::linkToCrud('Cache size', 'chip.svg', CacheSize::class),
            MenuItem::linkToCrud('RAM size', 'ram_multi.svg', MaxRam::class),
            MenuItem::linkToCrud('RAM type', 'ram.svg', DramType::class),
        ])->setPermission('ROLE_ADMIN');
        yield MenuItem::subMenu('Misc', 'misc.svg')->setSubItems([
            MenuItem::linkToCrud('Manufacturers', 'factory.svg', Manufacturer::class),
            MenuItem::linkToCrud('Known Issues', 'misc.svg', KnownIssue::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Creditors', 'creditor.svg', Creditor::class),
            MenuItem::linkToCrud('Licenses', 'license.svg', License::class)->setPermission('ROLE_ADMIN'),
            MenuItem::section('Advanced')->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Entity images', 'search_image.svg', EntityImage::class)->setController(EntityImageCrudController::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud('Entity docs', 'manual.svg', EntityDocumentation::class)->setController(EntityDocumentationCrudController::class)->setPermission('ROLE_ADMIN'),
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
