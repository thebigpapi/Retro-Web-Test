<?php

namespace App\Controller\Admin;

use App\Entity\LargeFile;
use App\Entity\LargeFileMediaTypeFlag;
use App\Form\Type\LanguageType;
use App\Form\Type\OsFlagType;
use App\Form\Type\LargeFileMediaTypeFlagType;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
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
        return $this->redirectToRoute($context->getDashboardRouteName());
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
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
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
            ->setDefaultSort(['lastEdited' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('fileVersion')
            ->add('file_name')
            ->add('subdirectory')
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name', 'Name')
            ->setColumns(4);
        yield TextField::new('fileVersion', 'Version')
            ->setColumns(4);
        yield ChoiceField::new('subdirectory', 'Type')
            ->setChoices([
                'apps' => 'apps',
                'drivers' => 'drivers',
            ])
            ->setFormTypeOption('placeholder', 'Type to select a type ...')
            ->setFormTypeOption('autocomplete', 'off')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('subdirectory', 'Type')
            ->onlyOnIndex();
        yield AssociationField::new('dumpQualityFlag','Quality')
            ->setFormTypeOption('placeholder', 'Type to select a quality ...')
            ->setColumns(4)
            ->onlyOnForms();
        yield DateField::new('release_date', 'Release Date')
            ->setFormTypeOption('attr', ['style'=>'width:100%;'])
            ->setColumns(2);
        yield ChoiceField::new('datePrecision', 'Display date format (optional)')
            ->setChoices([
                'Year, month and day' => 'd',
                'Year and month' => 'm',
                'Year only' => 'y',
            ])
            ->setFormTypeOption('placeholder', 'Type to select a format ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield TextareaField::new('file', 'File')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete', false)
            ->setColumns(4)
            ->onlyOnForms();
        yield CollectionField::new('languages', 'Language')
            ->setEntryType(LanguageType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('mediaTypeFlags', 'Media type flags')
            ->setEntryType(LargeFileMediaTypeFlagType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getMediaTypeFlags', 'Media type flags')
            ->onlyOnIndex();
        yield ArrayField::new('getOsFlags', 'OS flags')
            ->onlyOnIndex();
        yield CollectionField::new('osFlags', 'OS flags')
            ->setEntryType(OsFlagType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield DateField::new('lastEdited')
            ->hideOnForm();
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
        $driver->setSubdirectory($old->getSubdirectory());
        $driver->setDumpQualityFlag($old->getDumpQualityFlag());
        $driver->setReleaseDate($old->getReleaseDate());
        $driver->setDatePrecision($old->getDatePrecision());
        $driver->setNote($old->getNote());
        $driver->setLastEdited(new \DateTime('now'));
        foreach ($old->getLanguages() as $lang){
            $driver->addLanguage($lang);
        }
        foreach ($old->getOsFlags() as $flag){
            $driver->addOsFlag($flag);
        }
        foreach ($old->getMediaTypeFlags() as $media){
            $newMedia = new LargeFileMediaTypeFlag();
            $newMedia->setCount($media->getCount());
            $newMedia->setMediaTypeFlag($media->getMediaTypeFlag());
            $driver->addMediaTypeFlag($newMedia);
        }
        return $driver;
    }
    /**
     * @param LargeFile $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
