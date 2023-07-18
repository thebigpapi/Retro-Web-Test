<?php

namespace App\Controller\Admin;

use App\Entity\CacheMethod;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CacheMethodCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CacheMethod::class;
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
