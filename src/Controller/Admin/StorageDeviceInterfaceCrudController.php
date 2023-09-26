<?php

namespace App\Controller\Admin;

use App\Entity\StorageDeviceInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StorageDeviceInterfaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StorageDeviceInterface::class;
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
