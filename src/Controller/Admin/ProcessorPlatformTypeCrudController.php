<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Type\Chip\CPUIDCrudType;
use App\Controller\Admin\Type\EntityDocumentationCrudType;
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
            return $this->redirectToRoute('cpufamily_show', array('id'=>$entityId));
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
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('CPU family')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/486.svg width=48 height=48>CPU families')
            ->overrideTemplate('crud/edit', 'admin/crud/edit.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new.html.twig')
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('L1code')
            ->add('L1codeRatio')
            ->add('L1data')
            ->add('L1dataRatio')
            ->add('instructionSets')
            ->add('cpuid')
            ->add('processNode');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield IdField::new('id')
            ->hideOnForm();
        yield TextField::new('name', 'Name');
        yield NumberField::new('processNode', 'Process (in nm)')
            ->setColumns(2);
        yield AssociationField::new('L1code','L1 code size')
            ->setFormTypeOption('placeholder', 'Type to select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2);
        yield NumberField::new('L1codeRatio','L1 code ratio')
            ->setColumns(2)
            ->hideOnIndex();
        yield AssociationField::new('L1data','L1 data size')
            ->setFormTypeOption('placeholder', 'Type to select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2);
        yield NumberField::new('L1dataRatio','L1 data ratio')
            ->setColumns(2)
            ->hideOnIndex();
        yield CollectionField::new('dramType', 'RAM types')
            ->setEntryType(DramTypeType::class)
            ->renderExpanded()
            ->setColumns(6)
            ->onlyOnForms();
        yield ArrayField::new('dramType', 'RAM types')
            ->onlyOnDetail();
        yield CollectionField::new('instructionSets', 'Instruction set')
            ->setEntryType(InstructionSetType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('compatibleWith', 'Compatible with families')
            ->onlyOnDetail();
        yield ArrayField::new('instructionSets', 'Features (this entity)')
            ->onlyOnDetail();
        yield CollectionField::new('compatibleWith', 'Compatible with families')
            ->setEntryType(ProcessorPlatformTypeForm::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('cpuid', 'CPUID')
            ->useEntryCrudForm(CPUIDCrudType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('entityDocumentations', 'Documentation')
            ->onlyOnDetail();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield TextField::new('description')
            ->onlyOnDetail();
        yield FormField::addTab('Attachments')
            ->setIcon('fa fa-download')
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
        return $this->redirectToRoute('cpufamily_show', array('id'=>$entityId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
