<?php

namespace App\Controller\Admin;

use App\Entity\DramType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DramTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DramType::class;
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
