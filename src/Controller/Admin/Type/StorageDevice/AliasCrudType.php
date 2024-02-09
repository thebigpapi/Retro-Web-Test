<?php

namespace App\Controller\Admin\Type\StorageDevice;

use App\Entity\StorageDeviceAlias;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AliasCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StorageDeviceAlias::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('manufacturer')
            ->autocomplete()
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Type to select a manufacturer ...'])
            ->setColumns(4);
        yield TextField::new('partNumber')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Part number:'])
            ->setColumns(4);
        yield TextField::new('name')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Name:'])
            ->setColumns(4);
    }
}
