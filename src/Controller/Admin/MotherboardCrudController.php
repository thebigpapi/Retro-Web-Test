<?php

namespace App\Controller\Admin;

use App\Entity\Motherboard;
use App\Form\Type\MotherboardAliasType;
use App\Form\Type\MotherboardIdRedirectionType;
use App\Form\Type\DramTypeType;
use App\Form\Type\MotherboardMaxRamType;
use App\Form\Type\CacheSizeType;
use App\Form\Type\PSUConnectorType;
use App\Form\Type\MotherboardIoPortType;
use App\Form\Type\MotherboardExpansionSlotType;
use App\Form\Type\KnownIssueType;
use App\Form\Type\ExpansionChipType;
use App\Form\Type\LargeFileMotherboardType;
use App\Form\Type\MotherboardBiosType;
use App\Form\Type\ManualType;
use App\Form\Type\MiscFileType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorPlatformTypeForm;
use App\Form\Type\ProcessorSpeedType;
use App\Form\Type\MotherboardImageTypeForm;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
class MotherboardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Motherboard::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('info')
            ->onlyOnForms();
        // index items
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('getManufacturerShortNameIfExist','Manufacturer')
            ->hideOnForm();
        yield TextField::new('name')
            ->hideOnForm();
        yield BooleanField::new('getManuals','Manual?')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getMotherboardBios','BIOS?')
            ->renderAsSwitch(false)
            ->onlyOnIndex();

        // show items
        yield ArrayField::new('motherboardAliases', 'Alternative names')
            ->onlyOnDetail();
        yield TextField::new('chipset', 'Chipset')
            ->onlyOnDetail();
        yield ArrayField::new('cpuSockets', 'CPU socket')
            ->onlyOnDetail();
        yield ArrayField::new('processorPlatformTypes', 'CPU family')
            ->onlyOnDetail();
        yield ArrayField::new('cpuSpeed', 'FSB speed')
            ->onlyOnDetail();
        yield ArrayField::new('cacheSize', 'Cache')
            ->onlyOnDetail();
        yield ArrayField::new('dramType', 'RAM type')
            ->onlyOnDetail();
        /*yield ArrayField::new('motherboardMaxRams', 'RAM size')
            ->onlyOnDetail();*/
        yield ArrayField::new('psuConnectors', 'PSU connectors')
            ->onlyOnDetail();
        yield TextField::new('formFactor','Form Factor')
            ->onlyOnDetail();
        yield ArrayField::new('getChipsetParts', 'Chipset parts')
            ->onlyOnDetail();
        yield ArrayField::new('expansionChips', 'Expansion chips')
            ->onlyOnDetail();
        /*yield ArrayField::new('knownIssues', 'Known issues')
            ->onlyOnDetail();*/

        // show and indes
        yield DateField::new('lastEdited')
            ->hideOnForm();

        // editor items
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('name')
        ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('slug')
        ->setColumns(4)
            ->onlyOnForms();
        yield CollectionField::new('motherboardAliases', 'Alternative names')
            ->setEntryType(MotherboardAliasType::class)
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->setEntryType(MotherboardIdRedirectionType::class)
            ->setColumns(6)
            ->onlyOnForms();
        yield FormField::addPanel('Misc')
            ->onlyOnForms();
        yield AssociationField::new('formFactor','Form Factor')
            ->setColumns(6)
            ->onlyOnForms();
        yield TextField::new('dimensions')
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Advanced Data')
            ->setIcon('database')
            ->onlyOnForms();
        yield FormField::addPanel('Memory')->onlyOnForms();
        /*yield CollectionField::new('motherboardMaxRams', 'Supported RAM size')
            ->setEntryType(MotherboardMaxRamType::class)
            ->onlyOnForms();  broken*/
        yield CollectionField::new('dramType', 'Supported RAM types')
            ->setEntryType(DramTypeType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('cacheSize', 'Cache')
            ->setEntryType(CacheSizeType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addPanel('Connections')
            ->onlyOnForms();
        yield CollectionField::new('psuConnectors', 'PSU connectors')
            ->setEntryType(PSUConnectorType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('motherboardIoPorts', 'I/O ports')
            ->setEntryType(MotherboardIoPortType::class)
            ->onlyOnForms();
        yield CollectionField::new('motherboardExpansionSlots', 'Expansion slots')
            ->setEntryType(MotherboardExpansionSlotType::class)
            ->onlyOnForms();
        yield FormField::addPanel('Chips')
            ->onlyOnForms();
        yield AssociationField::new('chipset')
            ->onlyOnForms();
        yield CollectionField::new('expansionChips', 'Expansion chipset')
            ->setEntryType(ExpansionChipType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('CPU stuff')
            ->setIcon('microchip')
            ->onlyOnForms();
        yield CollectionField::new('cpuSockets', 'CPU sockets')
            ->setEntryType(CpuSocketType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('processorPlatformTypes', 'CPU families')
            ->setEntryType(ProcessorPlatformTypeForm::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('cpuSpeed', 'FSB speed')
            ->setEntryType(ProcessorSpeedType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(MotherboardImageTypeForm::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileMotherboardType::class)
            ->renderExpanded()
            ->onlyOnForms();
        /*yield CollectionField::new('motherboardBios', 'BIOS images')
            ->setEntryType(MotherboardBiosType::class)
            ->renderExpanded()
            ->onlyOnForms();*/
        yield CollectionField::new('manuals', 'Documentation')
            ->setEntryType(ManualType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('miscFiles', 'Misc files')
            ->setEntryType(MiscFileType::class)
            ->renderExpanded()
            ->onlyOnForms();

    }
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')
        ->setIcon('fa fa-copy')
        ->linkToUrl(
            fn (Motherboard $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::EDIT)
                ->setEntityId($entity->getId())
                ->set('duplicate', '1')
                ->generateUrl()
        );
        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function edit(AdminContext $context)
    {
        if ($context->getRequest()->query->has('duplicate')) {
            $entity = $context->getEntity()->getInstance();
            /** @var Motherboard $cloned */
            $cloned = clone $entity;
            $cloned->setLastEdited(new \DateTime('now'));
            $context->getEntity()->setInstance($cloned);
        }

        return parent::edit($context);
    }
}
