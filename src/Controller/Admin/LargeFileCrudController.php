<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Type\LargeFile\ExpansionCardCrudType;
use App\Controller\Admin\Type\LargeFile\ExpansionChipCrudType;
use App\Entity\LargeFile;
use App\Form\Type\OsFlagType;
use App\Form\Type\OsArchitectureType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LargeFileCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return LargeFile::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('driver_show', array('id'=>$entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (LargeFile $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::NEW)
                ->set('duplicate', $entity->getId())
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewDriver');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewDriver')->setIcon('fa fa-magnifying-glass');
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
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100)
            ->setEntityLabelInSingular('driver')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/hardware.svg width=48 height=48>Drivers')
            ->overrideTemplate('crud/edit', 'admin/crud/edit_driver.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new_driver.html.twig')
            ->setDefaultSort(['id' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('fileVersion')
            ->add('file_name',)
            ->add('osFlags')
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('data.svg')
            ->onlyOnForms();
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name', 'Name')
            ->setColumns('col-sm-6 col-lg-4 col-xxl-3');
        yield TextField::new('fileVersion', 'Version')
            ->setColumns('col-sm-6 col-lg-4 col-xxl-3');
        yield TextField::new('getSizeFormatted', 'Size')
            ->onlyOnIndex();
        yield DateField::new('releaseDate', 'Release Date')
            ->setFormTypeOption('attr', ['style'=>'width:100%;'])
            ->renderAsText()
            ->setColumns('col-sm-6 col-lg-4 col-xxl-3')
            ->onlyOnForms();
        yield TextField::new('getReleaseDateString', 'Release Date')
            ->onlyOnIndex();
        yield TextareaField::new('file', 'File')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete', false)
            ->setColumns('col-sm-6 col-lg-4 col-xxl-3')
            ->onlyOnForms();
        yield CollectionField::new('osArchitecture', 'OS architecture')
            ->setEntryType(OsArchitectureType::class)
            ->setColumns('col-sm-6 col-lg-4 col-xxl-3')
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getOsFlags', 'OS support')
            ->onlyOnIndex();
        yield CollectionField::new('osFlags', 'OS support')
            ->setEntryType(OsFlagType::class)
            ->setColumns('col-sm-6 col-lg-4 col-xxl-3')
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();
            yield ChoiceField::new('datePrecision', '')
            ->setChoices([
                'Year, month and day' => 'd',
                'Year and month' => 'm',
                'Year only' => 'y',
            ])
            ->renderAsNativeWidget()
            ->setColumns(2)
            ->onlyOnForms();
        yield FormField::addTab('Associations')
            ->setIcon('chip.svg')
            ->onlyOnForms();
        yield CollectionField::new('chips', 'Chips')
            ->useEntryCrudForm(ExpansionChipCrudType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-12 col-xxl-6')
            ->onlyOnForms();
        yield CollectionField::new('expansionCards', 'Expansion cards')
            ->useEntryCrudForm(ExpansionCardCrudType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-12 col-xxl-6')
            ->onlyOnForms();

    }
    public function viewDriver(AdminContext $context)
    {
        $driverId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('driver_show', array('id'=>$driverId));
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
            /** @var LargeFile $cloned */
            $cloned = $this->makeNewLargeFile($oldentity);
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
    public function makeNewLargeFile(LargeFile $old): LargeFile
    {
        $driver = new LargeFile();
        $driver->setName($old->getName());
        $driver->setFileVersion($old->getFileVersion());
        $driver->setReleaseDate($old->getReleaseDate());
        $driver->setDatePrecision($old->getDatePrecision());
        $driver->setNote($old->getNote());
        $driver->setLastEdited(new \DateTime('now'));
        foreach ($old->getOsFlags() as $flag){
            $driver->addOsFlag($flag);
        }
        return $driver;
    }
    /**
     * @param LargeFile $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //dd($entityInstance->getReleaseDateString());
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
