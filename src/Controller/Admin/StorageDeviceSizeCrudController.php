<?php

namespace App\Controller\Admin;

use App\Entity\StorageDeviceSize;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StorageDeviceSizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StorageDeviceSize::class;
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
