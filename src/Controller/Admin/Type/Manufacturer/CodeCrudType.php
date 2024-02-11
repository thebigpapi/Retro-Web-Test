<?php

namespace App\Controller\Admin\Type\Manufacturer;

use App\Entity\ManufacturerCode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CodeCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ManufacturerCode::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('value')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'FCC/UL/N/E code:'])
            ->setColumns(12);
    }
}