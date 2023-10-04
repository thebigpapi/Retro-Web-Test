<?php

namespace App\Controller\Admin;

use App\Entity\HardDrive;
use App\Form\Type\AudioFileType;
use App\Form\Type\KnownIssueType;
use App\Form\Type\StorageDeviceAliasType;
use App\Form\Type\StorageDeviceDocumentationType;
use App\Form\Type\StorageDeviceImageTypeForm;
use App\Form\Type\StorageDeviceInterfaceType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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

class HardDriveCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return HardDrive::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (HardDrive $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::NEW)
                ->set('duplicate', $entity->getId())
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewHardDrive');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewHardDrive')->setIcon('fa fa-magnifying-glass');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add('storageDeviceAliases')
            ->add('capacity')
            ->add('cylinders')
            ->add('heads')
            ->add('sectors')
            ->add('platters')
            ->add('spindleSpeed')
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
        yield CollectionField::new('interfaces', 'Interface')
            ->setEntryType(StorageDeviceInterfaceType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield AssociationField::new('physicalSize', 'Physical size')
            //->setEntryType(StorageDeviceSizeType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('getCapacityFormatted', 'Capacity')
            ->onlyOnIndex();
        yield NumberField::new('capacity')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2')
            ->onlyOnForms();
        yield NumberField::new('cylinders')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield NumberField::new('heads')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield NumberField::new('sectors')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield NumberField::new('spindleSpeed', 'RPM')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield NumberField::new('platters')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
        yield CollectionField::new('storageDeviceAliases', 'Alternative names')
            ->setEntryType(StorageDeviceAliasType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueType::class)
            ->renderExpanded()
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
        yield CollectionField::new('audioFiles', 'Audio files')
            ->setEntryType(AudioFileType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();

        // show and index
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
    }
    public function viewHardDrive(AdminContext $context)
    {
        $hddId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('hard_drive_show', array('id'=>$hddId));
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
            /** @var HardDrive $cloned */
            $cloned = clone $oldentity;
            $cloned->setLastEdited(new \DateTime('now'));
            foreach ($cloned->getStorageDeviceAliases() as $item){
                $man = $item->getManufacturer();
                $name = $item->getName();
                $partNumber = $item->getPartNumber();
                $cloned->removeStorageDeviceAlias($item);
                $cloned->addAlias($man, $name, $partNumber);
            }
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
    /**
     * @param HardDrive $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}

