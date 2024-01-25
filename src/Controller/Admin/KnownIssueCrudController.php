<?php

namespace App\Controller\Admin;

use App\Entity\KnownIssue;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class KnownIssueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return KnownIssue::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
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
            ->setEntityLabelInSingular('known issue')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/misc.svg width=48 height=48>Known issues')
            ->setPaginatorPageSize(100);
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name');
        yield ChoiceField::new('type')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->setFormTypeOption('placeholder', 'Select a type ...')
            ->setFormTypeOption('choices', [
                'Motherboards' => 1,
                'Expansion cards' => 2,
                'Hard drives' => 3,
                'Optical drives' => 4,
                'Floppy drives' => 5,
                'CPUs' => 6
            ])
            ->onlyOnForms();
        yield TextField::new('getTypeFormatted', 'Type')
            ->onlyOnIndex();
        yield TextField::new('description', 'Description')
            ->hideOnForm();
        yield CodeEditorField::new('description', 'Description')
            ->setLanguage('markdown')
            ->onlyOnForms();
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}