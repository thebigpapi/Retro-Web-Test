<?php

namespace App\Controller\Admin;

use App\Entity\HardDrive;
use App\Form\Type\AudioFileType;
use App\Form\Type\KnownIssueType;
use App\Form\Type\StorageDeviceAliasType;
use App\Form\Type\StorageDeviceDocumentationType;
use App\Form\Type\StorageDeviceImageTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

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
                ->setAction(Action::EDIT)
                ->setEntityId($entity->getId())
                ->set('duplicate', '1')
                ->generateUrl()
        );
        $view = Action::new('view', 'View')->linkToCrudAction('viewHardDrive');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            //->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $view)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100)
            ->overrideTemplate('crud/edit', 'admin/crud/edit_mobo.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new_mobo.html.twig');
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name');
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
        yield NumberField::new('capacity')
            ->setColumns('col-sm-4 col-lg-3 col-xxl-2');
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
    /**
     * @param HardDrive $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}

