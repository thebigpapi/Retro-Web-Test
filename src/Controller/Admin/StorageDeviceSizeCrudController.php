<?php

namespace App\Controller\Admin;

use App\Entity\StorageDeviceSize;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StorageDeviceSizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StorageDeviceSize::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('storage size')
            ->setEntityLabelInPlural('Storage physical size')
            ->setPaginatorPageSize(100);
    }
}
