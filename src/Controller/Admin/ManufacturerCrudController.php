<?php

namespace App\Controller\Admin;

use App\Entity\Manufacturer;
use App\Form\Type\ManufacturerBiosManufacturerCodeType;
use App\Form\Type\PciVendorIdType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ManufacturerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Manufacturer::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('manufacturer')
            ->setEntityLabelInPlural('Manufacturers')
            ->setPaginatorPageSize(100);
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name');
        yield TextField::new('fullName', 'Full name');
        yield ArrayField::new('getPciVendorIds', 'PCI Vendor')
            ->hideOnForm();
        yield CollectionField::new('pciVendorIds', 'PCI Vendor')
            ->setEntryType(PciVendorIdType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getBiosCodes', 'BIOS codes')
            ->onlyOnIndex();
        yield CollectionField::new('biosCodes', 'BIOS codes')
            ->setEntryType(ManufacturerBiosManufacturerCodeType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
    }
}
