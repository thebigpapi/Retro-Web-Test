<?php

namespace App\Controller\Admin;

use App\Entity\IoPort;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IoPortCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IoPort::class;
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
