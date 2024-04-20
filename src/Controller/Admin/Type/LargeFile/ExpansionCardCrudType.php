<?php

namespace App\Controller\Admin\Type\LargeFile;

use App\Entity\LargeFileExpansionCard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ExpansionCardCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LargeFileExpansionCard::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('expansionCard', 'Expansion card')
            ->autocomplete()
            ->setColumns(12);
        yield BooleanField::new('isRecommended', 'Known good');
    }
}
