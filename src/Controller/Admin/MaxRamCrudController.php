<?php

namespace App\Controller\Admin;

use App\Entity\MaxRam;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MaxRamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaxRam::class;
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
