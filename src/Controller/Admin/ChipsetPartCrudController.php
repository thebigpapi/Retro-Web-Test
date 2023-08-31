<?php

namespace App\Controller\Admin;

use App\Entity\ChipsetPart;
use App\Form\Type\ChipAliasType;
use App\Form\Type\LargeFileChipsetPartType;
use App\Form\Type\PciDeviceIdType;
use App\Form\Type\ChipDocumentationType;
use App\Form\Type\ChipImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChipsetPartCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChipsetPart::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)
            ->showEntityActionsInlined();
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add('chipAliases')
            ->add('rank');
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
            ->setFormTypeOption('placeholder', 'Select a manufacturer ...')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('partNumber', 'Part number')
            ->setColumns(4);
        yield TextField::new('name', 'Name')
            ->setColumns(4);
        yield NumberField::new('rank','Rank')
            ->setColumns(6);
        yield CollectionField::new('pciDevs', 'PCI DEV')
            ->setEntryType(PciDeviceIdType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getPciDevs', 'PCI DEV')
            ->hideOnForm();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield BooleanField::new('getImages','Images')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDocumentations','Docs')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDrivers','Drivers')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->setEntryType(ChipAliasType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileChipsetPartType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->setEntryType(ChipDocumentationType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ChipImageType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
    }
}
