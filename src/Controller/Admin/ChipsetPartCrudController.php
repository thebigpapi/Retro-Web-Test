<?php

namespace App\Controller\Admin;

use App\Entity\ChipsetPart;
use App\Form\Type\ChipAliasType;
use App\Form\Type\PciDeviceIdType;
use App\Form\Type\ChipDocumentationType;
use App\Form\Type\ChipImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
            ->onlyOnForms();
        yield TextField::new('partNumber', 'Part number');
        yield TextField::new('name', 'Name');
        yield NumberField::new('rank','Rank');
        // index
        yield ArrayField::new('pciDevs', 'PCI DEV')
            ->hideOnForm();
        yield BooleanField::new('getImages','Images')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDocumentations','Docs')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        // editor

        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->setEntryType(ChipAliasType::class)
            ->onlyOnForms();
        yield CollectionField::new('pciDevs', 'PCI DEV')
            ->setEntryType(PciDeviceIdType::class)
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->setEntryType(ChipDocumentationType::class)
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ChipImageType::class)
            ->onlyOnForms();
        yield TextareaField::new('description')->onlyOnForms();
    }
}
