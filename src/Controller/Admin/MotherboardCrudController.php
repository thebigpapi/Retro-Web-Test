<?php

namespace App\Controller\Admin;

use App\Entity\Motherboard;
use App\Controller\Admin\Filter\MotherboardImageFilter;
use App\Controller\Admin\Filter\MotherboardBiosFilter;
use App\Controller\Admin\Type\Motherboard\BiosCrudType;
use App\Controller\Admin\Type\Motherboard\AliasCrudType;
use App\Controller\Admin\Type\Motherboard\IdRedirectionCrudType;
use App\Controller\Admin\Type\Motherboard\MaxRamCrudType;
use App\Controller\Admin\Type\Motherboard\IoPortCrudType;
use App\Controller\Admin\Type\Motherboard\ExpansionSlotCrudType;
use App\Controller\Admin\Type\Motherboard\ImageCrudType;
use App\Controller\Admin\Type\Motherboard\LargeFileCrudType;
use App\Controller\Admin\Type\Motherboard\ManualCrudType;
use App\Controller\Admin\Type\Motherboard\MemoryConnectorCrudType;
use App\Controller\Admin\Type\MiscFileCrudType;
use App\Entity\MotherboardAlias;
use App\Entity\MotherboardExpansionSlot;
use App\Entity\MotherboardIoPort;
use App\Entity\MotherboardMaxRam;
use App\Entity\MotherboardMemoryConnector;
use App\Form\Type\DramTypeType;
use App\Form\Type\CacheSizeType;
use App\Form\Type\PSUConnectorType;
use App\Form\Type\KnownIssueMotherboardType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorPlatformTypeForm;
use App\Form\Type\ProcessorSpeedType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class MotherboardCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return Motherboard::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $boardId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('motherboard_show', array('id'=>$boardId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (Motherboard $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::NEW)
                ->set('duplicate', $entity->getId())
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewBoard');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewBoard')->setIcon('fa fa-magnifying-glass');
        $del = Action::new('deletemobo', 'Delete')->addCssClass('text-danger')->linkToCrudAction('deleteBoard');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
            ->add(Crud::PAGE_INDEX, $del)
            ->reorder(Crud::PAGE_INDEX, ['view', 'logs', Action::EDIT, 'deletemobo'])
            ->setPermission($del, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100)
            ->setEntityLabelInSingular('motherboard')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/board.svg width=48 height=48>Motherboards')
            ->overrideTemplate('crud/edit', 'admin/crud/edit_slug.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new_slug.html.twig')
            ->setDefaultSort(['lastEdited' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('motherboardAliases')
            ->add('chipset')
            ->add(MotherboardImageFilter::new('images'))
            ->add(MotherboardBiosFilter::new('motherboardBios'))
            ->add('expansionChips')
            ->add('cacheSize')
            ->add('dramType')
            ->add('processorPlatformTypes')
            ->add('cpuSockets')
            ->add('maxCpu')
            ->add('cpuSpeed')
            ->add('formFactor')
            ->add('knownIssues')
            ->add('psuConnectors')
            ->add('dimensions')
            ->add('score')
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        // index items
        yield IdField::new('id')
            ->onlyOnIndex();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('required', false)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield TextField::new('name')
            ->hideOnForm();
        yield AssociationField::new('chipset','Chipset')
            ->formatValue(function ($value, $entity) {return $entity->getChipsetWithoutParts();})
            ->setCustomOption('link','chipset.getId')
            ->onlyOnIndex();
        yield CollectionField::new('expansionChips','Exp.chips')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('manuals','Manual')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('motherboardBios','BIOS')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield TextField::new('isImages','Images')
            ->setCustomOption('imageTypes', true)
            ->onlyOnIndex();
        yield IntegerField::new('score','Score')
            ->onlyOnIndex();
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
        // edit items
        yield TextField::new('name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('slug')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->useEntryCrudForm(IdRedirectionCrudType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('motherboardAliases', 'Alternative names')
            ->useEntryCrudForm(AliasCrudType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-12 col-xxl-8')
            ->onlyOnForms();
        yield FormField::addPanel('Memory')->onlyOnForms();
        yield CollectionField::new('motherboardMaxRams', 'Supported RAM size')
            ->useEntryCrudForm(MaxRamCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('dramType', 'Supported RAM types')
            ->setEntryType(DramTypeType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('cacheSize', 'Cache')
            ->setEntryType(CacheSizeType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield AssociationField::new('maxVideoRam', 'Max VRAM (onboard GPU)')
            ->setFormTypeOption('placeholder', 'Type to select a VRAM size ...')
            ->setFormTypeOption('required', false)
            ->onlyOnForms();
        yield FormField::addPanel('Misc')
            ->onlyOnForms();
        yield AssociationField::new('formFactor','Form Factor')
            ->setFormTypeOption('required', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('dimensions')
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueMotherboardType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Chips')
            ->setIcon('fa fa-microchip')
            ->onlyOnForms();
        yield FormField::addPanel('CPU stuff')->onlyOnForms();
        yield CollectionField::new('cpuSockets', 'CPU sockets')
            ->setEntryType(CpuSocketType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('processorPlatformTypes', 'CPU families')
            ->setEntryType(ProcessorPlatformTypeForm::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->setFormTypeOption('row_attr', ['id'=> 'mobo-cpu-families-form'])
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('cpuSpeed', 'FSB speed')
            ->setEntryType(ProcessorSpeedType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield IntegerField::new('maxcpu', 'CPU socket count')
            ->setFormTypeOption('error_bubbling', false)
            ->onlyOnForms();
        yield FormField::addPanel('Chipset and chips')
            ->onlyOnForms();
        yield AssociationField::new('expansionChips', 'Expansion chips')
            ->autocomplete()
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6 multi-widget-trw')
            ->onlyOnForms();
        yield AssociationField::new('chipset')
            ->autocomplete()
            ->setFormTypeOption('required', false)
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->onlyOnForms();
        yield FormField::addTab('Connectors')
            ->setIcon('fa fa-plug')
            ->onlyOnForms();
        yield CollectionField::new('motherboardIoPorts', 'I/O ports')
            ->useEntryCrudForm(IoPortCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('motherboardExpansionSlots', 'Expansion slots')
            ->useEntryCrudForm(ExpansionSlotCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        /*yield CollectionField::new('motherboardMemoryConnectors', 'Memory connectors')
            ->useEntryCrudForm(MemoryConnectorCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();*/
        yield CollectionField::new('psuConnectors', 'PSU connectors')
            ->setEntryType(PSUConnectorType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('BIOS images')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('motherboardBios', 'BIOS')
            ->useEntryCrudForm(BiosCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setFormTypeOption('label', false)
            ->addCssClass('mobo-bios')
            ->setColumns(12)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Drivers')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->useEntryCrudForm(LargeFileCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->renderExpanded()
            ->setColumns(6)
            ->onlyOnForms();
        yield ArrayField::new('getChipsWithDrivers', 'Expansion chips with drivers')
            ->setCssClass("field-collection processed")
            ->setDisabled()
            ->onlyOnForms();
        yield FormField::addTab('Docs')
            ->setIcon('fa fa-file-pdf')
            ->onlyOnForms();
        yield CollectionField::new('manuals', 'Documentation')
            ->useEntryCrudForm(ManualCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('miscFiles', 'Misc files')
            ->useEntryCrudForm(MiscFileCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Images')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->useEntryCrudForm(ImageCrudType::class)
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->setFormTypeOption('error_bubbling', false)
            ->renderExpanded()
            ->onlyOnForms();
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
            $oldmobo = $entityManager->find($className, $context->getRequest()->query->get('duplicate'));
            /** @var Motherboard $cloned */
            $cloned = $this->makeNewMotherboard($oldmobo, $entityManager);
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
    public function makeNewMotherboard(Motherboard $old, EntityManagerInterface $entityManager): Motherboard
    {
        $board = new Motherboard();
        $board->setManufacturer($old->getManufacturer());
        $board->setName($old->getName());
        $board->setFormFactor($old->getFormFactor());
        $board->setDimensions($old->getDimensions());
        $board->setNote($old->getNote());
        $board->setMaxCpu($old->getMaxCpu());
        $board->setMaxVideoRam($old->getMaxVideoRam());
        $board->setChipset($old->getChipset());
        $board->setLastEdited(new \DateTime('now'));
        foreach ($old->getMotherboardAliases() as $alias){
            $newAlias = new MotherboardAlias();
            $newAlias->setManufacturer($alias->getManufacturer());
            $newAlias->setName($alias->getName());
            $board->addMotherboardAlias($newAlias);
        }
        foreach ($old->getKnownIssues() as $issue){
            $board->addKnownIssue($issue);
        }
        foreach ($old->getCpuSockets() as $socket){
            $board->addCpuSocket($socket);
        }
        foreach ($old->getProcessorPlatformTypes() as $family){
            $board->addProcessorPlatformType($family);
        }
        foreach ($old->getCpuSpeed() as $fsb){
            $board->addCpuSpeed($fsb);
        }
        foreach ($old->getExpansionChips() as $chip){
            $board->addExpansionChip($chip);
        }
        foreach ($old->getDramType() as $ram){
            $board->addDramType($ram);
        }
        foreach ($old->getCacheSize() as $cache){
            $board->addCacheSize($cache);
        }
        foreach ($old->getMotherboardMaxRams() as $ram){
            $newRam = new MotherboardMaxRam();
            $newRam->setMaxram($ram->getMaxram());
            $newRam->setNote($ram->getNote());
            $board->addMotherboardMaxRam($newRam);
        }
        foreach ($old->getMotherboardExpansionSlots() as $slot){
            $newSlot = new MotherboardExpansionSlot();
            $newSlot->setCount($slot->getCount());
            $newSlot->setExpansionSlot($slot->getExpansionSlot());
            $board->addMotherboardExpansionSlot($newSlot);
        }
        foreach ($old->getMotherboardIoPorts() as $port){
            $newPort = new MotherboardIoPort();
            $newPort->setCount($port->getCount());
            $newPort->setIoPort($port->getIoPort());
            $board->addMotherboardIoPort($newPort);
        }
        foreach ($old->getMotherboardMemoryConnectors() as $connector){
            $newConnector = new MotherboardMemoryConnector();
            $newConnector->setCount($connector->getCount());
            $newConnector->setMemoryConnector($connector->getMemoryConnector());
            $board->addMotherboardMemoryConnector($newConnector);
        }
        foreach ($old->getPsuConnectors() as $psu){
            $board->addPsuConnector($psu);
        }
        return $board;
    }

    public function viewBoard(AdminContext $context)
    {
        $boardId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('motherboard_show', array('id'=>$boardId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }

    public function deleteBoard(AdminContext $context)
    {
        $boardId = $context->getEntity()->getInstance()->getId();
        $url = $this->adminUrlGenerator
        ->setController(MotherboardCrudController::class)
        ->setRoute('motherboard_delete', array('id'=>$boardId))
        //->setAction(Action::EDIT)
        ->setEntityId($boardId)
        ->generateUrl();
        return $this->redirect($url);
        //return $this->redirectToRoute('motherboard_delete', array('id'=>$boardId));
    }
    /**
     * @param Motherboard $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        $entityInstance->updateHashAll();
        $entityInstance->updateScore();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
