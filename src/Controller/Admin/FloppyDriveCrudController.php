<?php

namespace App\Controller\Admin;

use App\Entity\FloppyDrive;
use App\Entity\StorageDeviceAlias;
use App\Form\Type\KnownIssueFddType;
use App\Form\Type\StorageDeviceInterfaceType;
use App\Form\Type\PSUConnectorType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\Filter\StorageImageFilter;
use App\Controller\Admin\Filter\StorageDocFilter;
use App\Controller\Admin\Type\MiscFileCrudType;
use App\Controller\Admin\Type\StorageDevice\AliasCrudType;
use App\Controller\Admin\Type\StorageDevice\DocumentationCrudType;
use App\Controller\Admin\Type\StorageDevice\IdRedirectionCrudType;
use App\Controller\Admin\Type\StorageDevice\ImageCrudType;
use App\Form\Type\FloppyDriveTypeType;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class FloppyDriveCrudController extends AbstractCrudController
{    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return FloppyDrive::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('floppy_drive_show', array('id'=>$entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (FloppyDrive $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::NEW)
                ->set('duplicate', $entity->getId())
                ->generateUrl()
        );

        $view = Action::new('view', 'View')->linkToCrudAction('viewFloppyDrive');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewFloppyDrive')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        $del = Action::new('deletefdd', 'Delete')->addCssClass('text-danger')->linkToCrudAction('deleteFdd');

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
            ->reorder(Crud::PAGE_INDEX, ['view', 'logs', Action::EDIT, 'deletefdd'])
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('floppy drive')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/floppy_drive.svg width=48 height=48>Floppy &amp; tape drives')
            ->overrideTemplate('crud/edit', 'admin/crud/edit.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new.html.twig')
            ->setPaginatorPageSize(100)
            ->setDefaultSort(['lastEdited' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add('storageDeviceAliases')
            ->add('type')
            ->add(StorageImageFilter::new('images'))
            ->add(StorageDocFilter::new('documentations'))
            ->add('interfaces')
            ->add('powerConnectors')
            ->add('physicalSize')
            ->add('lastEdited')
            ->add('description');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('data.svg')
            ->onlyOnForms();
        // index items
        yield IdField::new('id')
            ->onlyOnIndex();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('required', false)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');

        // editor items

        yield TextField::new('name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield TextField::new('partNumber')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4');
        yield ArrayField::new('interfaces', 'Interface')
            ->onlyOnIndex();
        yield AssociationField::new('physicalSize', 'Physical size')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield ArrayField::new('type')
            ->onlyOnIndex();
        yield TextField::new('isStorageDeviceImage','Images')
            ->setCustomOption('imageTypes', true)
            ->onlyOnIndex();
        yield CollectionField::new('storageDeviceDocumentations','Docs')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('type')
            ->setEntryType(FloppyDriveTypeType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addRow();
        yield CollectionField::new('interfaces', 'Interface')
            ->setEntryType(StorageDeviceInterfaceType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('powerConnectors', 'Power connectors')
            ->setEntryType(PSUConnectorType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueFddType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->useEntryCrudForm(IdRedirectionCrudType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('storageDeviceAliases', 'Alternative names')
            ->useEntryCrudForm(AliasCrudType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-12 col-xxl-6')
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Docs')
            ->setIcon('manual.svg')
            ->onlyOnForms();
        yield CollectionField::new('storageDeviceDocumentations', 'Documentation')
            ->useEntryCrudForm(DocumentationCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Images')
            ->setIcon('search_image.svg')
            ->onlyOnForms();
        yield CollectionField::new('storageDeviceImages', 'Images')
            ->useEntryCrudForm(ImageCrudType::class)
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->setFormTypeOption('error_bubbling', false)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Other attachments')
            ->setIcon('dw.svg')
            ->onlyOnForms();
        yield CollectionField::new('storageDeviceMiscFiles', 'Misc files')
            ->useEntryCrudForm(MiscFileCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        // show and index
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
    }
    public function viewFloppyDrive(AdminContext $context)
    {
        $fddId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('floppy_drive_show', array('id'=>$fddId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
    public function deleteFdd(AdminContext $context)
    {
        $fddId = $context->getEntity()->getInstance()->getId();
        $url = $this->adminUrlGenerator
        ->setController(FloppyDriveCrudController::class)
        ->setRoute('floppy_drive_delete', array('id'=>$fddId))
        ->setEntityId($fddId)
        ->generateUrl();
        return $this->redirect($url);
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
            /** @var FloppyDrive $cloned */
            $cloned = $this->makeNewFloppyDrive($oldentity);
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
    public function makeNewFloppyDrive(FloppyDrive $old): FloppyDrive
    {
        $fdd = new FloppyDrive();
        $fdd->setManufacturer($old->getManufacturer());
        $fdd->setName($old->getName());
        $fdd->setPartNumber($old->getPartNumber());
        $fdd->setPhysicalSize($old->getPhysicalSize());
        //$fdd->setDensity($old->getDensity());
        $fdd->setDescription($old->getDescription());
        $fdd->setLastEdited(new \DateTime('now'));
        foreach ($old->getStorageDeviceAliases() as $alias){
            $newAlias = new StorageDeviceAlias();
            $newAlias->setManufacturer($alias->getManufacturer());
            $newAlias->setName($alias->getName());
            $newAlias->setPartNumber($alias->getPartNumber());
            $fdd->addStorageDeviceAlias($newAlias);
        }
        foreach ($old->getPowerConnectors() as $pwr){
            $fdd->addPowerConnector($pwr);
        }
        foreach ($old->getKnownIssues() as $issue){
            $fdd->addKnownIssue($issue);
        }
        foreach ($old->getInterfaces() as $interface){
            $fdd->addInterface($interface);
        }
        return $fdd;
    }
    /**
     * @param FloppyDrive $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
