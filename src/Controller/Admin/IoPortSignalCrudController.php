<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Type\EntityDocumentationCrudType;
use App\Controller\Admin\Type\EntityImageCrudType;
use App\Entity\IoPortSignal;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IoPortSignalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IoPortSignal::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('I/O port signal')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/rs232_electric.svg width=48 height=48>I/O port signals')
            ->overrideTemplate('crud/edit', 'admin/crud/edit.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new.html.twig')
            ->setPaginatorPageSize(100);
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('data.svg')
            ->onlyOnForms();
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Docs')
            ->setIcon('manual.svg')
            ->onlyOnForms();
        yield CollectionField::new('entityDocumentations', 'Documentation')
            ->useEntryCrudForm(EntityDocumentationCrudType::class)
            ->setCustomOption('byCount', true)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6);
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
