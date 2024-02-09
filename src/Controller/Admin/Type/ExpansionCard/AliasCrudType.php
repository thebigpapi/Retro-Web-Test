<?php

namespace App\Controller\Admin\Type\ExpansionCard;

use App\Entity\ExpansionCardAlias;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AliasCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCardAlias::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('manufacturer', 'Manufacturer')
            ->autocomplete()
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Type to select a manufacturer ...'])
            ->setColumns(4);
        yield TextField::new('name', 'Name')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Name:'])
            ->setColumns(8);
    }
}
