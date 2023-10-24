<?php

namespace App\Controller\Admin;

use App\Entity\ProcessorPlatformType;
use App\Form\Type\EntityDocumentationType;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProcessorPlatformTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProcessorPlatformType::class;
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
            ->add('processNode');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('info')
            ->onlyOnForms();
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name');
        yield IntegerField::new('processNode', 'Process (in nm)')
            ->hideOnForm();
        yield NumberField::new('processNode', 'Process (in nm)')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L1code','L1 code size')
            ->setFormTypeOption('placeholder', 'Select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('L1codeRatio','L1 code ratio')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L1data','L1 data size')
            ->setFormTypeOption('placeholder', 'Select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('L1dataRatio','L1 data ratio')
            ->setColumns(2)
            ->onlyOnForms();
        yield BooleanField::new('hasIMC', 'Integrated Memory Controller')
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('instructionSets', 'Instruction set')
            ->setEntryType(InstructionSetType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getCompatibleWith', 'Compatible with families')
            ->onlyOnIndex();
        yield CollectionField::new('compatibleWith', 'Compatible with families')
            ->setEntryType(ProcessorPlatformTypeForm::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('entityDocumentations', 'Documentation')
            ->setEntryType(EntityDocumentationType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->onlyOnForms();
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
