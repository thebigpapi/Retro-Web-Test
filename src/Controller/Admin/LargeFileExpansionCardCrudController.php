<?php

namespace App\Controller\Admin;

use App\Entity\LargeFileExpansionCard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class LargeFileExpansionCardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LargeFileExpansionCard::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('largeFile', 'Driver')
            ->autocomplete()
            ->setColumns(12);
        yield BooleanField::new('isRecommended', 'Recommended');
    }
}
