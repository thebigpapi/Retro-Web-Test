<?php

namespace App\Controller\Admin;

use App\Entity\MaxRam;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MaxRamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaxRam::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield NumberField::new('value');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined()->setPaginatorPageSize(100);
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
}
