<?php

namespace App\Controller\Admin;

use App\Entity\IoPortInterfaceSignal;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IoPortInterfaceSignalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return IoPortInterfaceSignal::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
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
            ->setEntityLabelInSingular('I/O port preset')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/rs232.svg width=48 height=48>I/O port presets')
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('signal')
            ->add('interface');
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield AssociationField::new('signal','Electrical interface')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield AssociationField::new('interface','Mechanical interface')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        /*yield TextField::new('name', 'Name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield TextField::new('slug')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield ArrayField::new('type','Type')->onlyOnIndex();
        // index
        yield TextField::new('isExpansionCardImage','Images')
            ->onlyOnIndex();
        yield BooleanField::new('isExpansionCardBios','BIOS')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDocumentations','Docs')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDrivers','Drivers')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield CollectionField::new('type','Type')
            ->setEntryType(ExpansionCardTypeType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield AssociationField::new('expansionSlotInterface','Interface connector')
            ->setFormTypeOption('required', true)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield AssociationField::new('expansionSlotSignal','Interface signal')
            ->setFormTypeOption('required', true)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('ioPorts', 'I/O ports')
            ->setEntryType(ExpansionCardIoPortType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('expansionCardAliases', 'Alternative names')
            ->setEntryType(ExpansionCardAliasType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->setEntryType(ExpansionCardIdRedirectionType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Specs')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield FormField::addPanel('Memory')->onlyOnForms();
        yield CollectionField::new('ramSize', 'Supported RAM size')
            ->setEntryType(MaxRamType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('dramType', 'Supported RAM types')
            ->setEntryType(DramTypeType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('expansionCardMemoryConnectors', 'Memory connectors')
            ->setEntryType(ExpansionCardMemoryConnectorType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('expansionChips', 'Expansion chips')
            ->setEntryType(ExpansionChipType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->onlyOnForms();
        yield CollectionField::new('powerConnectors', 'Power connectors')
            ->setEntryType(PSUConnectorType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('BIOS images')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('expansionCardBios', 'BIOS')
            ->setEntryType(ExpansionCardBiosType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Other attachments')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ExpansionCardImageType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->setEntryType(ExpansionCardDocumentationType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileExpansionCardType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();*/
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
