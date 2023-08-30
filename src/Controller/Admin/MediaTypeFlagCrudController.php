<?php

namespace App\Controller\Admin;

use App\Entity\MediaTypeFlag;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaTypeFlagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MediaTypeFlag::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name');
        yield TextField::new('tagName');
        yield TextField::new('file_name')
            ->setFormTypeOption('disabled','disabled')
            ->onlyOnForms();
        yield TextareaField::new('icon')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete', false)
            ->onlyOnForms();
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined();
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
}
