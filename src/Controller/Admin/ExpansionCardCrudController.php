<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionCard;
use App\Form\Type\ExpansionCardTypeType;
use App\Form\Type\PSUConnectorType;
use App\Form\Type\KnownIssueExpansionCardType;
use App\EasyAdmin\TextJsonField;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\Type\ExpansionCard\IoPortInterfaceSignalCrudType;
use App\Controller\Admin\Type\ExpansionCard\MemoryConnectorCrudType;
use App\Controller\Admin\Filter\ExpansionCardImageFilter;
use App\Controller\Admin\Filter\ChipDocFilter;
use App\Controller\Admin\Filter\ChipDriverFilter;
use App\Controller\Admin\Filter\ExpansionCardBiosFilter;
use App\Controller\Admin\Type\ExpansionCard\AliasCrudType;
use App\Controller\Admin\Type\ExpansionCard\BiosCrudType;
use App\Controller\Admin\Type\ExpansionCard\DocumentationCrudType;
use App\Controller\Admin\Type\ExpansionCard\IdRedirectionCrudType;
use App\Controller\Admin\Type\ExpansionCard\ImageCrudType;
use App\Controller\Admin\Type\ExpansionCard\LargeFileCrudType;
use App\Controller\Admin\Type\ExpansionCard\PowerConnectorCrudType;
use App\Controller\Admin\Type\PciDeviceCrudType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
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
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('expansion card')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/card.svg width=48 height=48>Expansion cards')
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
            ->add('expansionSlotInterfaceSignal')
            ->add('expansionChips')
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
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield ArrayField::new('type','Type')
            ->onlyOnIndex();
        yield TextField::new('expansionSlotInterfaceSignal','Slot')
            ->onlyOnIndex();
        yield CollectionField::new('expansionChips', 'Exp.chips')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('getDocumentations','Docs')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('expansionCardBios','BIOS')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield TextField::new('isExpansionCardImage','Images')
            ->setCustomOption('imageTypes', true)
            ->onlyOnIndex();
        yield CollectionField::new('getDrivers','Drivers')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('type','Type')
            ->setEntryType(ExpansionCardTypeType::class)
            ->renderExpanded()
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield AssociationField::new('expansionSlotInterfaceSignal','Expansion slot preset')
            ->autocomplete()
            ->setFormTypeOption('required', true)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-2')
            ->onlyOnForms();
        yield AssociationField::new('expansionSlotInterface','Expansion slot connector')
            ->autocomplete()
            ->setFormTypeOption('required', true)
            ->setFormTypeOption('attr',['placeholder' => 'Type to select a connector ...'])
            ->setColumns('col-sm-6 col-lg-6 col-xxl-2')
            ->onlyOnForms();
        yield AssociationField::new('expansionSlotSignals','Expansion slot signals')
            ->setFormTypeOption('required', true)
            ->autocomplete()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->onlyOnForms();
        yield IntegerField::new('width', 'Width (mm)')
            ->setColumns('col-sm-2 col-lg-3 col-xxl-1')
            ->onlyOnForms();
        yield IntegerField::new('height', 'Height (mm)')
            ->setColumns('col-sm-2 col-lg-3 col-xxl-1')
            ->onlyOnForms();
        yield IntegerField::new('length', 'Length (mm)')
            ->setColumns('col-sm-2 col-lg-3 col-xxl-1')
            ->onlyOnForms();
        yield IntegerField::new('slotCount', 'Slot height')
            ->setColumns('col-sm-2 col-lg-3 col-xxl-1')
            ->onlyOnForms();
        yield TextField::new('fccid','FCC ID')
            ->setColumns('col-sm-4 col-lg-6 col-xxl-2')
            ->onlyOnForms();
        yield CollectionField::new('pciDevs', 'Device ID')
            ->useEntryCrudForm(PciDeviceCrudType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-2')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->useEntryCrudForm(IdRedirectionCrudType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('expansionCardAliases', 'Alternative names')
            ->useEntryCrudForm(AliasCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueExpansionCardType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Chips')
            ->setIcon('fa fa-microchip')
            ->onlyOnForms();
        yield AssociationField::new('expansionChips', 'Expansion chips')
            ->autocomplete()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->onlyOnForms();
        yield AssociationField::new('ramSize', 'Supported RAM size')
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->autocomplete()
            ->onlyOnForms();
        yield AssociationField::new('dramType', 'Supported RAM types')
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->autocomplete()
            ->onlyOnForms();
        yield FormField::addTab('Specs')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield TextJsonField::new('miscSpecs', 'Misc specs')
            ->setFormTypeOption('label', false)
            ->setColumns(12)
            ->onlyOnForms();
        yield FormField::addTab('Connectors')
            ->setIcon('fa fa-plug')
            ->onlyOnForms();
        yield CollectionField::new('ioPorts', 'I/O ports')
            ->useEntryCrudForm(IoPortInterfaceSignalCrudType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        /*yield CollectionField::new('expansionCardMemoryConnectors', 'Memory connectors')
            ->useEntryCrudForm(MemoryConnectorCrudType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();*/
        yield CollectionField::new('expansionCardPowerConnectors', 'Power connectors')
            ->useEntryCrudForm(PowerConnectorCrudType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Firmware')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('expansionCardBios', 'Firmware / BIOS images')
            ->useEntryCrudForm(BiosCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(12)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Other attachments')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->useEntryCrudForm(ImageCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->useEntryCrudForm(DocumentationCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->useEntryCrudForm(LargeFileCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
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
        $entityInstance->updateHashAll();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
