<?php

namespace App\Controller\Admin;

use App\Entity\ProcessorPlatformType;
use App\Form\Type\ProcessorPlatformTypeForm;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProcessorPlatformTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProcessorPlatformType::class;
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
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name');
        yield ArrayField::new('getCompatibleWith', 'Compatible with families')
            ->onlyOnIndex();
        yield CollectionField::new('compatibleWith', 'Compatible with families')
            ->setEntryType(ProcessorPlatformTypeForm::class)
            ->renderExpanded()
            ->onlyOnForms();
    }
}
