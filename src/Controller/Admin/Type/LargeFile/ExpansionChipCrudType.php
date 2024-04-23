<?php

namespace App\Controller\Admin\Type\LargeFile;

use App\Entity\LargeFileExpansionChip;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ExpansionChipCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LargeFileExpansionChip::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('expansionChip', 'Expansion chip')
            ->autocomplete()
            ->setColumns(12);
        yield BooleanField::new('isRecommended', 'Known good');
    }
}
