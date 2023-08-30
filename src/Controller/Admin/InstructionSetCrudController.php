<?php

namespace App\Controller\Admin;

use App\Entity\InstructionSet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InstructionSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InstructionSet::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100);
    }
    /*
    public function configureFields(string $pageName): iterable
    {
    }
    */
}
