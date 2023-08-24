<?php

namespace App\Controller\Admin;

use App\Entity\ChipsetPart;
use App\Form\Type\ChipAliasType;
use App\Form\Type\PciDeviceIdType;
use App\Form\Type\ChipDocumentationType;
use App\Form\Type\ChipImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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

    public function configureFields(string $pageName): iterable
    {
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
        yield NumberField::new('rank','Rank')
            ->setColumns(6);
        yield CollectionField::new('pciDevs', 'PCI DEV')
            ->setEntryType(PciDeviceIdType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('pciDevs', 'PCI DEV')
            ->hideOnForm();
        yield TextareaField::new('description')->onlyOnForms();
        yield FormField::addPanel('Other')->onlyOnForms();
        yield BooleanField::new('getImages','Images')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDocumentations','Docs')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
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
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->setEntryType(ChipAliasType::class)
            ->renderExpanded()
            ->onlyOnForms();
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined();
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
}
