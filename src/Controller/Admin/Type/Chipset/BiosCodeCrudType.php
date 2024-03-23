<?php

namespace App\Controller\Admin\Type\Chipset;

use App\Entity\ChipsetBiosCode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BiosCodeCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChipsetBiosCode::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('biosManufacturer')
            ->autocomplete()
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Type to select a chipset vendor ...'])
            ->setColumns(8);
        yield TextField::new('code')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Code:'])
            ->setColumns(4);
    }
}
