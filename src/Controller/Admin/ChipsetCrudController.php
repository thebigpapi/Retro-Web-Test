<?php

namespace App\Controller\Admin;

use App\Entity\Chipset;
use App\Entity\ChipsetAlias;
use App\Entity\ChipsetBiosCode;
use App\Form\Type\ExpansionChipType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\Filter\ChipDocFilter;
use App\Controller\Admin\Filter\ChipDriverFilter;
use App\Controller\Admin\Type\Chipset\AliasCrudType;
use App\Controller\Admin\Type\Chipset\BiosCodeCrudType;
use App\Controller\Admin\Type\Chipset\DocumentationCrudType;
use App\Controller\Admin\Type\Chipset\LargeFileCrudType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ChipsetCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return Chipset::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('chipset_show', array('id' => $entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (Chipset $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::NEW)
                ->set('duplicate', $entity->getId())
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewChipset');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewChipset')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs = Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
            ->add(Crud::PAGE_DETAIL, $elogs)
            ->add(Crud::PAGE_DETAIL, $eview)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100)
            ->setEntityLabelInSingular('chipset')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/chipset.svg width=48 height=48>Chipsets')
            ->setDefaultSort(['lastEdited' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('part_no')
            ->add(ChipDocFilter::new('documentations'))
            ->add(ChipDriverFilter::new('drivers'))
            ->add('expansionChips')
            ->add('chipsetAliases')
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('manufacturer', 'Manufacturer')
            ->setColumns(4);
        yield TextField::new('part_no', 'Part number')
            ->setColumns(4);
        yield TextField::new('name', 'Name')
            ->setColumns(4);
        yield ArrayField::new('getPartsCached', 'Parts')
            ->onlyOnIndex();
        yield ArrayField::new('expansionChips', 'Parts')
            ->onlyOnDetail();
        yield DateField::new('release_date', 'Release Date')
            ->setColumns(2)
            ->onlyOnForms();
        yield TextField::new('getReleaseDateString', 'Release Date')
            ->hideOnForm();
        yield ChoiceField::new('datePrecision', 'Display date format (optional)')
            ->setChoices([
                'Year, month and day' => 'd',
                'Year and month' => 'm',
                'Year only' => 'y',
            ])
            ->setFormTypeOption('placeholder', 'Select a format ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield UrlField::new('encyclopedia_link', 'Link')
            ->setColumns(4)
            ->hideOnIndex();
        yield CollectionField::new('documentations', 'Docs')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('getDrivers', 'Drivers')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield ArrayField::new('drivers', 'Drivers (this entity)')
            ->onlyOnDetail();
        yield ArrayField::new('documentations', 'Documentation   __(this entity)')
            ->onlyOnDetail();
        yield TextField::new('description')
            ->onlyOnDetail();
        yield DateField::new('lastEdited', 'Last edit')
            ->setFormTypeOption('disabled', 'disabled')
            ->setColumns(4);
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield CollectionField::new('expansionChips', 'Parts')
            ->setEntryType(ExpansionChipType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('biosCodes', 'BIOS codes')
            ->useEntryCrudForm(BiosCodeCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('chipsetAliases', 'Chipset aliases')
            ->useEntryCrudForm(AliasCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(12)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->useEntryCrudForm(DocumentationCrudType::class)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->useEntryCrudForm(LargeFileCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->renderExpanded()
            ->setColumns(6)
            ->onlyOnForms();
    }
    public function viewChipset(AdminContext $context)
    {
        $chipsetId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('chipset_show', array('id' => $chipsetId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-", $context->getEntity()->getFqcn());
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
            /** @var Chipset $cloned */
            $cloned = $this->makeNewChipset($oldentity);
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
    public function makeNewChipset(Chipset $old): Chipset
    {
        $chipset = new Chipset();
        $chipset->setPartNo($old->getPartNo());
        $chipset->setName($old->getName());
        $chipset->setManufacturer($old->getManufacturer());
        $chipset->setReleaseDate($old->getReleaseDate());
        $chipset->setDatePrecision($old->getDatePrecision());
        $chipset->setEncyclopediaLink($old->getEncyclopediaLink());
        $chipset->setDescription($old->getDescription());
        $chipset->setLastEdited(new \DateTime('now'));
        foreach ($old->getExpansionChips() as $chip) {
            $chipset->addExpansionChip($chip);
        }
        foreach ($old->getChipsetAliases() as $alias) {
            $newAlias = new ChipsetAlias();
            $newAlias->setManufacturer($alias->getManufacturer());
            $newAlias->setName($alias->getName());
            $newAlias->setPartNumber($alias->getPartNumber());
            $chipset->addChipsetAlias($newAlias);
        }
        foreach ($old->getBiosCodes() as $code) {
            $newCode = new ChipsetBiosCode();
            $newCode->setBiosManufacturer($code->getBiosManufacturer());
            $newCode->setCode($code->getCode());
            $chipset->addBiosCode($newCode);
        }
        return $chipset;
    }
    /**
     * @param Chipset $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
