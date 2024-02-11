<?php

namespace App\Controller\Admin\Type\Manufacturer;

use App\Entity\PciVendorId;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PciVendorCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PciVendorId::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('ven')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Vendor ID:'])
            ->setColumns(12);
    }
}