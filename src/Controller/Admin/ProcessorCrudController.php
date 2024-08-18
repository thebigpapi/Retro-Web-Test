<?php

namespace App\Controller\Admin;

use App\Entity\ChipAlias;
use App\Entity\Processor;
use App\Form\Type\CpuSocketType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\Filter\ChipImageFilter;
use App\Controller\Admin\Type\Chip\AliasCrudType;
use App\Controller\Admin\Type\Chip\ImageCrudType;
use App\Controller\Admin\Type\Chip\VoltageCrudType;
use App\Entity\ExpansionChipType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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

class ProcessorCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;
    private $entityManagerInterface;

    public function __construct(AdminUrlGenerator $adminUrlGenerator, EntityManagerInterface $entityManagerInterface)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManagerInterface = $entityManagerInterface;
    }
    public static function getEntityFqcn(): string
    {
        return Processor::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('processor_show', array('id'=>$entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (Processor $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::NEW)
                ->set('duplicate', $entity->getId())
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewCPU');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewCPU')->setIcon('fa fa-magnifying-glass');
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
            ->setEntityLabelInSingular('CPU')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/486dx.svg width=48 height=48>CPUs')
            ->overrideTemplate('crud/edit', 'admin/crud/edit.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new.html.twig')
            ->setPaginatorPageSize(100)
            ->setDefaultSort(['id' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add('chipAliases')
            ->add(ChipImageFilter::new('images'))
            ->add('sockets')
            ->add('platform')
            ->add('core')
            ->add('speed')
            ->add('fsb')
            ->add('tdp')
            ->add('ProcessNode')
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('data.svg')
            ->onlyOnForms();
        yield IdField::new('id')
            ->onlyOnIndex();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('placeholder', 'Type to select a manufacturer ...')
            ->setColumns(4);
        yield TextField::new('partNumber', 'Name')
            ->setColumns(4);
        yield TextField::new('name', 'Part number')
            ->setColumns(4);
        yield AssociationField::new('platform', 'Family')
            ->hideOnForm();
        yield TextField::new('core', 'Core')
            ->hideOnForm();
        yield TextField::new('speed', 'Speed')
            ->hideOnForm();
        yield TextField::new('fsb', 'FSB')
            ->setFormTypeOption('required', false)
            ->hideOnForm();
        yield IntegerField::new('ProcessNode', 'Process')
            ->hideOnForm();
        yield CollectionField::new('getImages','Images')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield AssociationField::new('platform', 'Family')
            ->setFormTypeOption('placeholder', 'Type to select a family ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield TextField::new('core', 'Core')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('speed','Frequency')
            ->setFormTypeOption('placeholder', 'Type to select a speed ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('fsb','Bus speed')
            ->setFormTypeOption('placeholder', 'Type to select a speed ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('tdp', 'TDP (in W)')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('ProcessNode', 'Process (in nm)')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('cores', 'Core count')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('threads', 'Thread count')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L2','L2 size')
            ->setFormTypeOption('placeholder', 'Type to select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield BooleanField::new('L2shared','L2 shared')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L3','L3 size')
            ->setFormTypeOption('placeholder', 'Type to select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield BooleanField::new('L3shared','L3 shared')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield FormField::addRow();
        yield CollectionField::new('sockets', 'Socket')
            ->setEntryType(CpuSocketType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('voltages', 'Voltage')
            ->useEntryCrudForm(VoltageCrudType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addPanel('Other')->onlyOnForms();
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->useEntryCrudForm(AliasCrudType::class)
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
    }
    public function viewCPU(AdminContext $context)
    {
        $cpuId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('processor_show', array('id'=>$cpuId));
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
            /** @var Processor $cloned */
            $cloned = $this->makeNewProcessor($oldentity);
            $context->getEntity()->setInstance($cloned);
        }
        $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
        $entityInstance = $newForm->getData();
        // set CPU sort = 1 always
        if($entityInstance->getSort() != 1)
            $entityInstance->setSort(1);
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
    public function makeNewProcessor(Processor $old): Processor
    {
        $cpu = new Processor();
        $cpu->setManufacturer($old->getManufacturer());
        $cpu->setName($old->getName());
        $cpu->setPartNumber($old->getPartNumber());
        $cpu->setPlatform($old->getPlatform());
        $cpu->setCore($old->getCore());
        $cpu->setSpeed($old->getSpeed());
        $cpu->setFsb($old->getFsb());
        $cpu->setTdp($old->getTdp());
        $cpu->setProcessNode($old->getProcessNode());
        $cpu->setCores($old->getCores());
        $cpu->setThreads($old->getThreads());
        $cpu->setL2($old->getL2());
        $cpu->setL2shared($old->isL2shared());
        $cpu->setL3($old->getL3());
        $cpu->setL3shared($old->isL3shared());
        $cpu->setLastEdited(new \DateTime('now'));
        foreach ($old->getSockets() as $socket){
            $cpu->addSocket($socket);
        }
        foreach ($old->getVoltages() as $voltage){
            $newVoltage = new ProcessorVoltage();
            $newVoltage->setValue($voltage->getValue());
            $cpu->addVoltage($newVoltage);
        }
        foreach ($old->getChipAliases() as $alias){
            $newAlias = new ChipAlias();
            $newAlias->setManufacturer($alias->getManufacturer());
            $newAlias->setName($alias->getName());
            $newAlias->setPartNumber($alias->getPartNumber());
            $cpu->addChipAlias($newAlias);
        }
        return $cpu;
    }
    /**
     * @param Processor $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function createEntity(string $entityFqcn)
    {
        // To save the processors with a "processor" type (which is of id 10);
        $processorType = $this->entityManagerInterface->getRepository(ExpansionChipType::class)->find(10);
        $processor = new Processor();
        $processor->setType($processorType);

        return $processor;
    }
}
