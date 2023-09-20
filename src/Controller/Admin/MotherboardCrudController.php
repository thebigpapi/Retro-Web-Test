<?php

namespace App\Controller\Admin;

use App\Entity\Motherboard;
use App\Controller\Admin\Filter\MotherboardImageFilter;
use App\Form\Type\MotherboardAliasType;
use App\Form\Type\MotherboardIdRedirectionType;
use App\Form\Type\DramTypeType;
use App\Form\Type\MotherboardMaxRamType;
use App\Form\Type\CacheSizeType;
use App\Form\Type\PSUConnectorType;
use App\Form\Type\MotherboardIoPortType;
use App\Form\Type\MotherboardExpansionSlotType;
use App\Form\Type\KnownIssueType;
use App\Form\Type\ExpansionChipType;
use App\Form\Type\LargeFileMotherboardType;
use App\Form\Type\MotherboardBiosType;
use App\Form\Type\ManualType;
use App\Form\Type\MiscFileType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorPlatformTypeForm;
use App\Form\Type\ProcessorSpeedType;
use App\Form\Type\MotherboardImageTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')->setIcon('fa fa-copy')->linkToUrl(
            fn (Motherboard $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::EDIT)
                ->setEntityId($entity->getId())
                ->set('duplicate', '1')
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewBoard');
        $del = Action::new('delet1', 'Delete')->addCssClass('text-danger')->linkToCrudAction('deleteBoard');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_INDEX, $del)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(10)
            ->overrideTemplate('crud/edit', 'admin/crud/edit_mobo.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new_mobo.html.twig')
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
        yield BooleanField::new('isChipset','Chipset')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('isExpansionChips','Exp.chips')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('isManuals','Manual')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('isMotherboardBios','BIOS')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield TextField::new('isImages','Images')
            //->renderAsSwitch(false)
            ->onlyOnIndex();

        // show and index
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();

        // editor items
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('required', false)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('name')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('slug')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield FormField::addRow();
        yield CollectionField::new('motherboardAliases', 'Alternative names')
            ->setEntryType(MotherboardAliasType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->setEntryType(MotherboardIdRedirectionType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->onlyOnForms();
        yield FormField::addPanel('Misc')
            ->onlyOnForms();
        yield AssociationField::new('formFactor','Form Factor')
            ->setFormTypeOption('required', false)
            ->setColumns(6)
            ->onlyOnForms();
        yield TextField::new('dimensions')
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Advanced Data')
            ->setIcon('database')
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
        yield FormField::addPanel('Chips')
            ->onlyOnForms();
        yield CollectionField::new('expansionChips', 'Expansion chips')
            ->setEntryType(ExpansionChipType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->onlyOnForms();
        yield AssociationField::new('chipset')
            ->setFormTypeOption('placeholder', 'Select a chipset ...')
            ->setFormTypeOption('required', false)
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->onlyOnForms();
        yield FormField::addPanel('Memory')->onlyOnForms();
        yield CollectionField::new('motherboardMaxRams', 'Supported RAM size')
            ->setEntryType(MotherboardMaxRamType::class)
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
            ->setFormTypeOption('placeholder', 'Select a VRAM size ...')
            ->setFormTypeOption('required', false)
            ->onlyOnForms();
        yield FormField::addPanel('Connections')
            ->onlyOnForms();
        yield CollectionField::new('motherboardIoPorts', 'I/O ports')
            ->setEntryType(MotherboardIoPortType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('motherboardExpansionSlots', 'Expansion slots')
            ->setEntryType(MotherboardExpansionSlotType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('psuConnectors', 'PSU connectors')
            ->setEntryType(PSUConnectorType::class)
            ->setColumns('col-sm-12 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(MotherboardImageTypeForm::class)
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->setFormTypeOption('error_bubbling', false)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('manuals', 'Documentation')
            ->setEntryType(ManualType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('motherboardBios', 'BIOS images')
            ->setEntryType(MotherboardBiosType::class)
            ->addCssClass('mobo-bios')
            ->setColumns(12)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('miscFiles', 'Misc files')
            ->setEntryType(MiscFileType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileMotherboardType::class)
            ->renderExpanded()
            ->setColumns(6)
            ->onlyOnForms();
    }
    public function edit(AdminContext $context)
    {
        if ($context->getRequest()->query->has('duplicate')) {
            $entity = $context->getEntity()->getInstance();
            /** @var Motherboard $cloned */
            $cloned = clone $entity;
            $cloned->setLastEdited(new \DateTime('now'));
            $context->getEntity()->setInstance($cloned);
        }

        return parent::edit($context);
    }

    public function viewBoard(AdminContext $context)
    {
        $boardId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('motherboard_show', array('id'=>$boardId));
    }

    public function deleteBoard(AdminContext $context)
    {
        $boardId = $context->getEntity()->getInstance()->getId();
        $url = $this->adminUrlGenerator
        ->setController(ProductCrudController::class)
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
        parent::updateEntity($entityManager, $entityInstance);
    }
}
