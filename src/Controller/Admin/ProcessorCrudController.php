<?php

namespace App\Controller\Admin;

use App\Entity\Processor;
use App\Form\Type\ChipAliasType;
use App\Form\Type\ChipImageType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorVoltageType;
use App\Form\Type\InstructionSetType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
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

class ProcessorCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return Processor::class;
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
        return $crud
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add('sockets')
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
            ->setIcon('info')
            ->onlyOnForms();
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('getManufacturer','Manufacturer')
            ->hideOnForm();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('placeholder', 'Select a manufacturer ...')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('partNumber', 'Name')
            ->setColumns(4);
        yield TextField::new('name', 'Aux Name')
            ->setColumns(4);
        yield ArrayField::new('getChipAliases', 'Aliases')
            ->hideOnForm();
        yield TextField::new('core', 'Core')
            ->hideOnForm();
        yield TextField::new('speed', 'Speed')
            ->hideOnForm();
        yield TextField::new('fsb', 'FSB')
            ->hideOnForm();
        yield IntegerField::new('tdp', 'TDP')
            ->hideOnForm();
        yield IntegerField::new('ProcessNode', 'Process')
            ->hideOnForm();
        yield ArrayField::new('getVoltages', 'Voltage')
            ->hideOnForm();
        yield AssociationField::new('platform', 'Family')
            ->setFormTypeOption('placeholder', 'Select a family ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield TextField::new('core', 'Core')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('speed','Speed')
            ->setFormTypeOption('placeholder', 'Select a speed ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('fsb','FSB')
            ->setFormTypeOption('placeholder', 'Select a speed ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('tdp', 'TDP (in W)')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('ProcessNode', 'Process (in nm)')
            ->setColumns(2)
            ->onlyOnForms();
        yield CollectionField::new('sockets', 'Socket')
            ->setEntryType(CpuSocketType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('voltages', 'Voltage (in V)')
            ->setEntryType(ProcessorVoltageType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addPanel('Cache')->onlyOnForms();
        yield AssociationField::new('L1','L1 size')
            ->setFormTypeOption('placeholder', 'Select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L1CacheMethod','L1 method')
            ->setFormTypeOption('autocomplete', 'disabled')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L2','L2 size')
            ->setFormTypeOption('placeholder', 'Select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L2CacheRatio','L2 ratio')
            ->setFormTypeOption('autocomplete', 'disabled')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L3','L3 size')
            ->setFormTypeOption('placeholder', 'Select a size ...')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L3CacheRatio','L3 ratio')
            ->setFormTypeOption('autocomplete', 'disabled')
            ->setFormTypeOption('required', false)
            ->setColumns(2)
            ->onlyOnForms();
        yield FormField::addPanel('Other')->onlyOnForms();
        yield CollectionField::new('instructionSets', 'Instruction set')
            ->setEntryType(InstructionSetType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->setEntryType(ChipAliasType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ChipImageType::class)
            ->setColumns(12)
            ->renderExpanded()
            ->onlyOnForms();
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
    }
    public function viewCPU(AdminContext $context)
    {
        $cpuId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('processor_show', array('id'=>$cpuId));
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
            /** @var Processor $cloned */
            $cloned = clone $oldentity;
            $cloned->setLastEdited(new \DateTime('now'));
            foreach ($cloned->getChipAliases() as $item){
                $man = $item->getManufacturer();
                $name = $item->getName();
                $partNumber = $item->getPartNumber();
                $cloned->removeChipAlias($item);
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
}
