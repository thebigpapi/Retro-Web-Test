<?php

namespace App\Controller\Admin;

use App\Entity\CpuSpeed;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CpuSpeedCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CpuSpeed::class;
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
