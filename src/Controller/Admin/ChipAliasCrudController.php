<?php

namespace App\Controller\Admin;

use App\Entity\ChipAlias;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ChipAliasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChipAlias::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100)
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/chip_alias.svg width=48 height=48>Chip aliases');
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield UrlField::new('chip.getId', 'Chip')
            ->setCustomOption('link','chip/')
            ->formatValue(function ($value, $entity) {
                return $entity->getChip()->getFullName() ?: '[unknown]';
            })
            ->hideOnForm();
        yield AssociationField::new('chip')
            ->autocomplete()
            ->setDisabled()
            ->onlyOnForms();
        yield AssociationField::new('manufacturer')
            ->autocomplete()
            ->setFormTypeOption('attr',['placeholder' => 'Type to select a manufacturer ...']);
        yield TextField::new('partNumber', 'Part number')
            ->setFormTypeOption('attr',['placeholder' => 'Part number:']);
        yield TextField::new('name')
            ->setFormTypeOption('attr',['placeholder' => 'Name:']);
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
