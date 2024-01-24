<?php

namespace App\Controller\Admin;

use App\Entity\MotherboardAlias;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MotherboardAliasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MotherboardAlias::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('manufacturer', 'Manufacturer')
            ->autocomplete()
            ->setColumns(12);
        yield TextField::new('name', 'Name')
            ->setColumns(12);
    }
}
