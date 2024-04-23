<?php

namespace App\Controller\Admin\Type\Chipset;

use App\Entity\LargeFileChipset;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class LargeFileCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LargeFileChipset::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('largeFile', 'Driver')
            ->autocomplete()
            ->setColumns(12);
        yield BooleanField::new('isRecommended', 'Known good');
    }
}
