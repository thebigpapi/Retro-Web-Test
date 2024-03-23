<?php

namespace App\Controller\Admin\Type;

use App\Entity\PciDeviceId;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PciDeviceCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PciDeviceId::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('dev')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Device ID:'])
            ->setColumns(12);
    }
}