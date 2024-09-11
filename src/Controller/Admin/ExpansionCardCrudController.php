<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionCard;
use App\Entity\PciDeviceId;
use App\Form\Type\ExpansionCardTypeType;
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
use App\Entity\ExpansionCardAlias;
use App\Entity\ExpansionCardIoPort;
use App\Entity\ExpansionCardPowerConnector;
use App\Entity\LargeFileExpansionCard;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

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
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (ExpansionCard $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::NEW)
                ->set('duplicate', $entity->getId())
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewExpCard');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewExpCard')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_EDIT, $duplicate)
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
            ->overrideTemplate('crud/edit', 'admin/crud/edit_slug.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new_slug.html.twig')
            ->setPaginatorPageSize(100)
            ->setDefaultSort(['lastEdited' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('expansionCardAliases')
            ->add('type')
            ->add('expansionSlotInterfaceSignal')
            ->add('chips')
            ->add(ExpansionCardImageFilter::new('images'))
            ->add(ChipDocFilter::new('documentations'))
            ->add(ExpansionCardBiosFilter::new('expansionCardBios'))
            ->add(ChipDriverFilter::new('drivers'));
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('data.svg')
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
        yield CollectionField::new('chips', 'Chips')
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
        yield FormField::addTab('Connectors')
            ->setIcon('rs232.svg')
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
        yield FormField::addTab('Chips/specs')
            ->setIcon('chip.svg')
            ->onlyOnForms();
        yield AssociationField::new('chips', 'Chips')
            ->autocomplete()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->onlyOnForms();
        yield AssociationField::new('ramSize', 'Supported RAM size')
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->onlyOnForms();
        yield AssociationField::new('dramType', 'Supported RAM types')
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4 multi-widget-trw')
            ->onlyOnForms();
        yield TextJsonField::new('miscSpecs', 'Misc specs')
            ->setFormTypeOption('label', false)
            ->setColumns(12)
            ->onlyOnForms();
        yield FormField::addTab('BIOS')
            ->setIcon('awchip.svg')
            ->onlyOnForms();
        yield CollectionField::new('expansionCardBios', 'Firmware / BIOS images')
            ->useEntryCrudForm(BiosCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(12)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Drivers')
            ->setIcon('hardware.svg')
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->useEntryCrudForm(LargeFileCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getChipsWithDrivers', 'Expansion chips with drivers')
            ->setCssClass("field-collection processed")
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->setDisabled()
            ->onlyOnForms();
        yield FormField::addTab('Docs')
            ->setIcon('manual.svg')
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->useEntryCrudForm(DocumentationCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Images')
            ->setIcon('search_image.svg')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->useEntryCrudForm(ImageCrudType::class)
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
     * @return KeyValueStore|Response
     */
    public function new(AdminContext $context)
    {
        $event = new BeforeCrudActionEvent($context);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
            throw new ForbiddenActionException($context);
        }

        if (!$context->getEntity()->isAccessible()) {
            throw new InsufficientEntityPermissionException($context);
        }

        $context->getEntity()->setInstance($this->createEntity($context->getEntity()->getFqcn()));
        $this->container->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_NEW)));
        $context->getCrud()->setFieldAssets($this->getFieldAssets($context->getEntity()->getFields()));
        $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());
        if ($context->getRequest()->query->has('duplicate')) {
            $className = $this->getEntityFqcn();
            $entityManager = $this->container->get('doctrine')->getManagerForClass($className);
            $oldentity = $entityManager->find($className, $context->getRequest()->query->get('duplicate'));
            /** @var ExpansionCard $cloned */
            $cloned = $this->makeNewExpansionCard($oldentity);
            $context->getEntity()->setInstance($cloned);
        }
        $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
        $entityInstance = $newForm->getData();
        $newForm->handleRequest($context->getRequest());
        $context->getEntity()->setInstance($entityInstance);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->processUploadedFiles($newForm);

            $event = new BeforeEntityPersistedEvent($entityInstance);
            $this->container->get('event_dispatcher')->dispatch($event);
            $entityInstance = $event->getEntityInstance();

            $this->persistEntity($this->container->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);

            $this->container->get('event_dispatcher')->dispatch(new AfterEntityPersistedEvent($entityInstance));
            $context->getEntity()->setInstance($entityInstance);

            return $this->getRedirectResponseAfterSave($context, Action::NEW);
        }

        $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
            'pageName' => Crud::PAGE_NEW,
            'templateName' => 'crud/new',
            'entity' => $context->getEntity(),
            'new_form' => $newForm,
        ]));

        $event = new AfterCrudActionEvent($context, $responseParameters);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        return $responseParameters;
    }
    public function makeNewExpansionCard(ExpansionCard $old): ExpansionCard
    {
        $card = new ExpansionCard();
        $card->setName($old->getName());
        $card->setManufacturer($old->getManufacturer());
        $card->setSlug($old->getSlug());
        $card->setExpansionSlotInterfaceSignal($old->getExpansionSlotInterfaceSignal());
        $card->setExpansionSlotInterface($old->getExpansionSlotInterface());
        $card->setWidth($old->getWidth());
        $card->setHeight($old->getHeight());
        $card->setLength($old->getLength());
        $card->setSlotCount($old->getSlotCount());
        $card->setFccid($old->getFccid());
        $card->setDescription($old->getDescription());
        $card->setMiscSpecs($old->getMiscSpecs());
        $card->setLastEdited(new \DateTime('now'));
        foreach ($old->getType() as $typ){
            $card->addType($typ);
        }
        foreach ($old->getPciDevs() as $dev) {
            $newDev = new PciDeviceId();
            $newDev->setDev($dev->getDev());
            $card->addPciDev($newDev);
        }
        foreach ($old->getExpansionSlotSignals() as $sig){
            $card->addExpansionSlotSignal($sig);
        }
        foreach ($old->getKnownIssues() as $issue){
            $card->addKnownIssue($issue);
        }

        foreach ($old->getExpansionCardAliases() as $alias) {
            $newAlias = new ExpansionCardAlias();
            $newAlias->setManufacturer($alias->getManufacturer());
            $newAlias->setName($alias->getName());
            $card->addExpansionCardAlias($newAlias);
        }
        foreach ($old->getChips() as $chip) {
            $card->addChip($chip);
        }
        foreach ($old->getDramType() as $ram){
            $card->addDramType($ram);
        }
        foreach ($old->getRamSize() as $max){
            $card->addRamSize($max);
        }
        foreach ($old->getExpansionCardPowerConnectors() as $pwr){
            $newPwr = new ExpansionCardPowerConnector();
            $newPwr->setCount($pwr->getCount());
            $newPwr->setPowerConnector($pwr->getPowerConnector());
            $card->addExpansionCardPowerConnector($newPwr);
        }
        foreach ($old->getIoPorts() as $port){
            $newPort = new ExpansionCardIoPort();
            $newPort->setCount($port->getCount());
            $newPort->setIoPortInterfaceSignal($port->getIoPortInterfaceSignal());
            $newPort->setIoPortInterface($port->getIoPortInterface());
            foreach ($port->getIoPortSignals() as $sig){
                $newPort->addIoPortSignal($sig);
            }
            $card->addIoPort($newPort);
        }
        foreach ($old->getDrivers() as $drv){
            $newDrv = new LargeFileExpansionCard();
            $newDrv->setIsRecommended($drv->getIsRecommended());
            $newDrv->setLargeFile($drv->getLargeFile());
            $card->addDriver($newDrv);
        }
        return $card;
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
