<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionChip;
use App\Form\Type\ChipAliasType;
use App\Form\Type\PciDeviceIdType;
use App\Form\Type\LargeFileExpansionChipType;
use App\Form\Type\ChipDocumentationType;
use App\Form\Type\ChipImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExpansionChipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionChip::class;
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add('type');
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('info')
            ->onlyOnForms();
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('getManufacturer','Manufacturer')
            ->hideOnForm();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('partNumber', 'Part number')
            ->setColumns(4);
        yield TextField::new('name', 'Name')
            ->setColumns(4);
        yield TextField::new('type','Type')->onlyOnIndex();
        // index
        yield ArrayField::new('getPciDevs', 'PCI DEV')
            ->hideOnForm();
        yield BooleanField::new('getImages','Images')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDocumentations','Docs')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDrivers','Drivers')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        // editor
        yield AssociationField::new('type','Type')
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('pciDevs', 'PCI DEV')
            ->setEntryType(PciDeviceIdType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->setEntryType(ChipAliasType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->setEntryType(ChipDocumentationType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ChipImageType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileExpansionChipType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined()->setPaginatorPageSize(100);
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
}
