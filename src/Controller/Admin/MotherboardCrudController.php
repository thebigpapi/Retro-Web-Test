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
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
        yield DateField::new('lastEdited')->hideOnForm();

        // editor items
        yield AssociationField::new('manufacturer','Manufacturer')
            ->onlyOnForms();
        yield TextField::new('name')
            ->onlyOnForms();
        yield TextField::new('slug')
            ->onlyOnForms();
        yield CollectionField::new('motherboardAliases', 'Alternative names')
            ->setEntryType(MotherboardAliasType::class)
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->setEntryType(MotherboardIdRedirectionType::class)
            ->onlyOnForms();
        /*yield CollectionField::new('motherboardMaxRams', 'Supported RAM size')
            ->setEntryType(MotherboardMaxRamType::class)
            ->onlyOnForms();  broken*/
        yield CollectionField::new('dramType', 'Supported RAM types')
            ->setEntryType(DramTypeType::class)
            ->onlyOnForms();
        yield CollectionField::new('cacheSize', 'Cache')
            ->setEntryType(CacheSizeType::class)
            ->onlyOnForms();
        yield CollectionField::new('psuConnectors', 'PSU connectors')
            ->setEntryType(PSUConnectorType::class)
            ->onlyOnForms();
        /*yield CollectionField::new('motherboardIoPorts', 'I/O ports')
            ->setEntryType(MotherboardIoPortType::class)
            ->onlyOnForms();
        yield CollectionField::new('motherboardExpansionSlots', 'Expansion slots')
            ->setEntryType(MotherboardExpansionSlotType::class)
            ->onlyOnForms();*/
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueType::class)
            ->onlyOnForms();
        yield AssociationField::new('chipset')
            ->onlyOnForms();
        yield CollectionField::new('expansionChips', 'Expansion chipset')
            ->setEntryType(ExpansionChipType::class)
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileMotherboardType::class)
            ->onlyOnForms();
        /*yield CollectionField::new('motherboardBios', 'BIOS images')
            ->setEntryType(MotherboardBiosType::class)
            ->onlyOnForms();*/
        yield CollectionField::new('manuals', 'Documentation')
            ->setEntryType(ManualType::class)
            ->onlyOnForms();
        yield CollectionField::new('miscFiles', 'Misc files')
            ->setEntryType(MiscFileType::class)
            ->onlyOnForms();
        yield CollectionField::new('cpuSockets', 'CPU sockets')
            ->setEntryType(CpuSocketType::class)
            ->onlyOnForms();
        yield CollectionField::new('processorPlatformTypes', 'CPU families')
            ->setEntryType(ProcessorPlatformTypeForm::class)
            ->onlyOnForms();
        yield CollectionField::new('cpuSpeed', 'FSB speed')
            ->setEntryType(ProcessorSpeedType::class)
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(MotherboardImageTypeForm::class)
            ->onlyOnForms();
        yield AssociationField::new('formFactor','Form Factor')
            ->onlyOnForms();
        yield TextField::new('dimensions');
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();

    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
}
