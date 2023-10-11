<?php

namespace App\Controller\Admin;

use App\Entity\Manufacturer;
use App\Form\Type\ManufacturerBiosManufacturerCodeType;
use App\Form\Type\PciVendorIdType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ManufacturerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Manufacturer::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('manufacturer')
            ->setEntityLabelInPlural('Manufacturers')
            ->setPaginatorPageSize(100);
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name');
        yield TextField::new('fullName', 'Full name');
        yield ArrayField::new('getPciVendorIds', 'Vendor ID')
            ->hideOnForm();
        yield CollectionField::new('pciVendorIds', 'Vendor ID')
            ->setEntryType(PciVendorIdType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getBiosCodes', 'BIOS codes')
            ->onlyOnIndex();
        yield CollectionField::new('biosCodes', 'BIOS codes')
            ->setEntryType(ManufacturerBiosManufacturerCodeType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
