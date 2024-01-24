<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionSlotInterfaceSignal;
use App\Form\Type\ExpansionSlotSignalType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ExpansionSlotInterfaceSignalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionSlotInterfaceSignal::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('expansion_slot_show', array('id' => $entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $view = Action::new('view', 'View')->linkToCrudAction('viewExpSlot');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewExpSlot')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('slot preset')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/card.svg width=48 height=48>Expansion slot presets')
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('signals')
            ->add('interface');
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield CollectionField::new('signals','Electrical interface')
            ->setEntryType(ExpansionSlotSignalType::class)
            ->renderExpanded()
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield AssociationField::new('interface','Mechanical interface')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
    }
    public function viewExpSlot(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('expansion_slot_show', array('id'=>$entityId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
