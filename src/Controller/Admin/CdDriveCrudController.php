<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\CdDriveTrayFilter;
use App\Entity\CdDrive;
use App\Entity\StorageDeviceAlias;
use App\Form\Type\AudioFileType;
use App\Form\Type\KnownIssueType;
use App\Form\Type\StorageDeviceAliasType;
use App\Form\Type\StorageDeviceDocumentationType;
use App\Form\Type\StorageDeviceIdRedirectionType;
use App\Form\Type\StorageDeviceImageTypeForm;
use App\Form\Type\StorageDeviceInterfaceType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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

class CdDriveCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return CdDrive::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (CdDrive $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::NEW)
                ->set('duplicate', $entity->getId())
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewCdDrive');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewCdDrive')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        $del = Action::new('deletecdd', 'Delete')->addCssClass('text-danger')->linkToCrudAction('deleteCdd');
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
            ->reorder(Crud::PAGE_INDEX, ['view', 'logs', Action::EDIT, 'deletecdd'])
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('optical drive')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/cd_drive.svg width=48 height=48>Optical drives')
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add('storageDeviceAliases')
            ->add('interfaces')
            ->add('physicalSize')
            ->add(CdDriveTrayFilter::new('trayType'))
            ->add('cdReadSpeed')
            ->add('cdWriteSpeed')
            ->add('dvdReadSpeed')
            ->add('dvdWriteSpeed')
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('info')
            ->onlyOnForms();
        // index items
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('manufacturer.name','Manufacturer')
            ->hideOnForm();
        yield TextField::new('name')
            ->hideOnForm();
        yield TextField::new('partNumber')
            ->hideOnForm();
        yield ArrayField::new('interfaces', 'Interface')
            ->onlyOnIndex();
        // editor items
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('required', false)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('partNumber')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield NumberField::new('cdReadSpeed', 'CD read')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield NumberField::new('cdWriteSpeed', 'CD write')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield NumberField::new('dvdReadSpeed', 'DVD read')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield NumberField::new('dvdWriteSpeed', 'DVD write')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield AssociationField::new('physicalSize', 'Physical size')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2')
            ->onlyOnForms();
        yield TextField::new('trayType')
            ->onlyOnIndex();
        yield ChoiceField::new('trayType')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2')
            ->setFormTypeOption('placeholder', 'Select a tray type ...')
            ->setFormTypeOption('choices', [
                'Tray' => 'Tray',
                'Caddy' => 'Caddy',
                'Slot' => 'Slot'
            ])
            ->onlyOnForms();
        yield FormField::addRow();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('interfaces', 'Interface')
            ->setEntryType(StorageDeviceInterfaceType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('storageDeviceAliases', 'Alternative names')
            ->setEntryType(StorageDeviceAliasType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->setEntryType(StorageDeviceIdRedirectionType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('storageDeviceImages', 'Images')
            ->setEntryType(StorageDeviceImageTypeForm::class)
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->setFormTypeOption('error_bubbling', false)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('storageDeviceDocumentations', 'Documentation')
            ->setEntryType(StorageDeviceDocumentationType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        // show and index
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
    }
    public function viewCdDrive(AdminContext $context)
    {
        $cddId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('cd_drive_show', array('id'=>$cddId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
    public function deleteCdd(AdminContext $context)
    {
        $cddId = $context->getEntity()->getInstance()->getId();
        $url = $this->adminUrlGenerator
        ->setController(CdDriveCrudController::class)
        ->setRoute('cd_drive_delete', array('id'=>$cddId))
        ->setEntityId($cddId)
        ->generateUrl();
        return $this->redirect($url);
    }

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
            /** @var CdDrive $cloned */
            $cloned = $this->makeNewCdDrive($oldentity);
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
    public function makeNewCdDrive(CdDrive $old): CdDrive
    {
        $cdd = new CdDrive();
        $cdd->setManufacturer($old->getManufacturer());
        $cdd->setName($old->getName());
        $cdd->setPartNumber($old->getPartNumber());
        $cdd->setPhysicalSize($old->getPhysicalSize());
        $cdd->setCdReadSpeed($old->getCdReadSpeed());
        $cdd->setCdWriteSpeed($old->getCdWriteSpeed());
        $cdd->setDvdReadSpeed($old->getDvdReadSpeed());
        $cdd->setDvdWriteSpeed($old->getDvdWriteSpeed());
        $cdd->setTrayType($old->getTrayType());
        $cdd->setDescription($old->getDescription());
        $cdd->setLastEdited(new \DateTime('now'));
        foreach ($old->getStorageDeviceAliases() as $alias){
            $newAlias = new StorageDeviceAlias();
            $newAlias->setManufacturer($alias->getManufacturer());
            $newAlias->setName($alias->getName());
            $newAlias->setPartNumber($alias->getPartNumber());
            $cdd->addStorageDeviceAlias($newAlias);
        }
        foreach ($old->getKnownIssues() as $issue){
            $cdd->addKnownIssue($issue);
        }
        foreach ($old->getInterfaces() as $interface){
            $cdd->addInterface($interface);
        }
        return $cdd;
    }
    /**
     * @param CdDrive $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
