<?php

namespace App\Controller\Admin;

use App\Entity\StorageDeviceInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StorageDeviceInterfaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StorageDeviceInterface::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('storage interface')
            ->setEntityLabelInPlural('Storage interfaces')
            ->setPaginatorPageSize(100);
    }
}
