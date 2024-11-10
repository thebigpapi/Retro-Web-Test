<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Type\Chip\CPUIDCrudType;
use App\Controller\Admin\Type\EntityDocumentationCrudType;
use App\EasyAdmin\TextJsonField;
use App\Entity\ProcessorPlatformType;
use App\Form\Type\DramTypeType;
use App\Form\Type\InstructionSetType;
use App\Form\Type\ProcessorPlatformTypeForm;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProcessorPlatformTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProcessorPlatformType::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('family_show', array('id'=>$entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $view = Action::new('view', 'View')->linkToCrudAction('viewFamily');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewFamily')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
            ->add(Crud::PAGE_DETAIL, $elogs)
            ->add(Crud::PAGE_DETAIL, $eview)
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('family')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/486.svg width=48 height=48>Chip families')
            ->overrideTemplate('crud/edit', 'admin/crud/edit.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new.html.twig')
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('dramType')
            ->add('compatibleWith')
            ->add('instructionSets')
            ->add('cpuSockets')
            ->add('description');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('data.svg')
            ->onlyOnForms();
        yield IdField::new('id')
            ->hideOnForm();
        yield TextField::new('name', 'Name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-3');
        yield CollectionField::new('dramType', 'RAM types')
            ->setEntryType(DramTypeType::class)
            ->renderExpanded()
            ->setColumns('col-sm-6 col-lg-6 col-xxl-3')
            ->onlyOnForms();
        yield ArrayField::new('dramType', 'RAM types')
            ->onlyOnDetail();
        yield ArrayField::new('compatibleWith', 'Compatible with families')
            ->onlyOnDetail();
        yield CollectionField::new('compatibleWith', 'Compatible with families')
            ->setEntryType(ProcessorPlatformTypeForm::class)
            ->renderExpanded()
            ->setColumns('col-sm-6 col-lg-6 col-xxl-3')
            ->onlyOnForms();
        yield ArrayField::new('entityDocumentations', 'Documentation')
            ->onlyOnDetail();
        yield CollectionField::new('instructionSets', 'Instruction set')
            ->setEntryType(InstructionSetType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-3')
            ->renderExpanded()
            ->onlyOnForms();
        yield AssociationField::new('cpuSockets','Sockets')
            ->autocomplete()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield TextField::new('description')
            ->onlyOnDetail();
        yield FormField::addTab('Specs')
            ->setIcon('tag.svg')
            ->onlyOnForms();
        yield TextJsonField::new('miscSpecs', 'Misc specs')
            ->setColumns(12)
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
    public function viewFamily(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('family_show', array('id'=>$entityId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
