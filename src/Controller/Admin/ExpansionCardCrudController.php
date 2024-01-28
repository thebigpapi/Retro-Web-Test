<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionCard;
use App\Form\Type\ExpansionCardAliasType;
use App\Form\Type\ExpansionCardBiosType;
use App\Form\Type\LargeFileExpansionCardType;
use App\Form\Type\ExpansionCardDocumentationType;
use App\Form\Type\ExpansionCardImageType;
use App\Form\Type\ExpansionCardIdRedirectionType;
use App\Form\Type\ExpansionCardMemoryConnectorType;
use App\Form\Type\ExpansionCardIoPortType;
use App\Form\Type\ExpansionCardTypeType;
use App\Form\Type\PSUConnectorType;
use App\Form\Type\PciDeviceIdType;
use App\Form\Type\KnownIssueExpansionCardType;
use App\EasyAdmin\TextJsonField;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\Filter\ExpansionCardImageFilter;
use App\Controller\Admin\Filter\ChipDocFilter;
use App\Controller\Admin\Filter\ChipDriverFilter;
use App\Controller\Admin\Filter\ExpansionCardBiosFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ExpansionCardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCard::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('expansioncard_show', array('id'=>$entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $view = Action::new('view', 'View')->linkToCrudAction('viewExpCard');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewExpCard')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('expansion card')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/chip.svg width=48 height=48>Expansion cards')
            ->overrideTemplate('crud/edit', 'admin/crud/edit_card.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new_card.html.twig')
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('expansionCardAliases')
            ->add('type')
            ->add(ExpansionCardImageFilter::new('images'))
            ->add(ChipDocFilter::new('documentations'))
            ->add(ExpansionCardBiosFilter::new('expansionCardBios'))
            ->add(ChipDriverFilter::new('drivers'));
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield TextField::new('name', 'Name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield TextField::new('slug')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4')
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
        yield AssociationField::new('expansionSlotInterfaceSignal','Expansion slot preset')
            ->setFormTypeOption('placeholder', 'Type to select a slot preset ...')
            ->setFormTypeOption('required', true)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield AssociationField::new('expansionSlotInterface','Interface connector')
            ->setFormTypeOption('required', true)
            ->setFormTypeOption('placeholder', 'Type to select a connector ...')
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield AssociationField::new('expansionSlotSignal','Interface signal')
            ->setFormTypeOption('placeholder', 'Type to select a signal ...')
            ->setFormTypeOption('required', true)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield IntegerField::new('width', 'Width (in mm)')
            ->setColumns('col-sm-2 col-lg-2 col-xxl-1');
        yield IntegerField::new('height', 'Height (in mm)')
            ->setColumns('col-sm-2 col-lg-2 col-xxl-1');
        yield IntegerField::new('length', 'Length (in mm)')
            ->setColumns('col-sm-2 col-lg-2 col-xxl-1');
        yield IntegerField::new('slotCount', 'Slot height')
            ->setColumns('col-sm-2 col-lg-2 col-xxl-1');
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
        yield CollectionField::new('type','Type')
            ->setEntryType(ExpansionCardTypeType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('pciDevs', 'Device ID')
            ->setEntryType(PciDeviceIdType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield TextField::new('fccid','FCC ID')
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueExpansionCardType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Features')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield FormField::addPanel('Memory and chips')->onlyOnForms();
        yield AssociationField::new('ramSize', 'Supported RAM size')
            //->setEntryType(MaxRamType::class)
            //->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            //->renderExpanded()
            ->autocomplete()
            ->onlyOnForms();
        yield AssociationField::new('dramType', 'Supported RAM types')
            //->setEntryType(DramTypeType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            //->renderExpanded()
            ->autocomplete()
            ->onlyOnForms();
        yield AssociationField::new('expansionChips', 'Expansion chips')
            ->autocomplete()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->onlyOnForms();
        yield FormField::addPanel('Connections')->onlyOnForms();
        yield CollectionField::new('ioPorts', 'I/O ports')
            ->setEntryType(ExpansionCardIoPortType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('expansionCardMemoryConnectors', 'Memory connectors')
            ->setEntryType(ExpansionCardMemoryConnectorType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('powerConnectors', 'Power connectors')
            ->setEntryType(PSUConnectorType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Specs')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield TextJsonField::new('miscSpecs', 'Misc specs')
            ->setColumns(12)
            ->onlyOnForms();
        yield FormField::addTab('Firmware')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('expansionCardBios', 'Firmware / BIOS images')
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
            ->setFormTypeOption('error_bubbling', false)
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
            ->useEntryCrudForm(LargeFileExpansionCardCrudController::class)
            //->setEntryType(LargeFileExpansionCardType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
    }
    public function viewExpCard(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('expansioncard_show', array('id'=>$entityId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
    /**
     * @param ExpansionCard $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
