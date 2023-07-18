<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionChip;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExpansionChipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionChip::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
