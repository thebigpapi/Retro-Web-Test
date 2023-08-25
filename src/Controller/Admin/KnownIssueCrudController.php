<?php

namespace App\Controller\Admin;

use App\Entity\KnownIssue;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class KnownIssueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return KnownIssue::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name');
        yield TextField::new('description', 'Description')
            ->hideOnForm();
        yield CodeEditorField::new('description', 'Description')
            ->setLanguage('markdown')
            ->onlyOnForms();
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined()->setPaginatorPageSize(100);
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
}
