<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Type\EntityImageCrudType;
use App\Controller\Admin\Type\Manufacturer\BiosCodeCrudType;
use App\Controller\Admin\Type\Manufacturer\CodeCrudType;
use App\Controller\Admin\Type\Manufacturer\PciVendorCrudType;
use App\Entity\Manufacturer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class ManufacturerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Manufacturer::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $view = Action::new('view', 'View')->linkToCrudAction('viewManufacturer');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewManufacturer')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
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
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('manufacturer')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/factory.svg width=48 height=48>Manufacturers')
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('fullName')
            ->add('pciVendorIds')
            ->add('manufacturerCodes')
            ->add('biosCodes');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield IdField::new('id')
            ->hideOnForm();
        yield TextField::new('name', 'Name')
            ->setColumns(6);
        yield TextField::new('fullName', 'Full name')
            ->setColumns(6);
        yield ArrayField::new('getPciVendorIds', 'Vendor ID')
            ->hideOnForm();
        yield CollectionField::new('manufacturerCodes', 'Codes')
            ->useEntryCrudForm(CodeCrudType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('manufacturerCodes', 'Codes')
            ->hideOnForm();
        yield CollectionField::new('pciVendorIds', 'Vendor ID')
            ->useEntryCrudForm(PciVendorCrudType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getBiosCodes', 'BIOS codes')
            ->hideOnForm();
        yield CollectionField::new('biosCodes', 'BIOS codes')
            ->useEntryCrudForm(BiosCodeCrudType::class)
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->renderExpanded()
            ->onlyOnForms();
        yield TextField::new('description')
            ->onlyOnDetail();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('entityImages', 'Images')
            ->useEntryCrudForm(EntityImageCrudType::class)
            ->setCustomOption('byCount', true)
            ->renderExpanded()
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6);
    }
    public function viewManufacturer(AdminContext $context)
    {
        $manufacturerId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('manufacturer_show', array('id'=>$manufacturerId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
