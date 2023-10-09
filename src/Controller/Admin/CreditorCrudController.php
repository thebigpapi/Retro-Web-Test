<?php

namespace App\Controller\Admin;

use App\Entity\Creditor;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class CreditorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Creditor::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $view = Action::new('view', 'View images')->linkToCrudAction('viewImages');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, $view)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('creditor')
            ->setEntityLabelInPlural('Creditors')
            ->setPaginatorPageSize(100);
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name')
            ->setColumns(6);
        yield FormField::addRow();
        yield UrlField::new('website', 'Website')
            ->setColumns(6);
        yield FormField::addRow();
        yield TextField::new('license.name', 'License')
            ->onlyOnIndex();
        yield AssociationField::new('license', 'License')
            ->setFormTypeOption('required', false)
            ->setColumns(6)
            ->onlyOnForms();
    }
    public function viewImages(AdminContext $context, AdminUrlGenerator $adminUrlGenerator)
    {
        $id = $context->getEntity()->getInstance()->getId();
        $name = $context->getEntity()->getInstance()->getName();
        $targetUrl = $adminUrlGenerator
            ->setController(self::class)
            ->setRoute('dashboard_creditor_images', ['id' => $id, 'name' => $name])
            ->setEntityId($id)
            ->generateUrl();
        return $this->redirect($targetUrl);
    }
}
