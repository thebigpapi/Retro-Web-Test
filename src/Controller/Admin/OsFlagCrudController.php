<?php

namespace App\Controller\Admin;

use App\Entity\OsFlag;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OsFlagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OsFlag::class;
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
