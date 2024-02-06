<?php

namespace App\Controller\Admin;

use App\Entity\MotherboardImage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MotherboardImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MotherboardImage::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100)
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/search_image.svg width=48 height=48>Motherboard images');
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('creditor')
            ->add('motherboardImageType')
            ->add('description')
            ->add('updated_at');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('motherboard')->hideOnForm();
        yield AssociationField::new('motherboard')
            ->autocomplete()
            ->onlyOnForms();
        yield AssociationField::new('creditor', 'Creditor')
            ->autocomplete()
            ->setColumns(4);
        yield AssociationField::new('motherboardImageType', 'Type')
            ->setColumns(4);
        yield TextField::new('description', 'Notes')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4');
        yield ImageField::new('file_name', 'Image')
            ->setCustomOption('link','motherboard/image')
            ->setCustomOption('thumb_link','media/cache/show_thumb/motherboard/image')
            ->hideOnForm();
        yield TextField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4')
            ->onlyOnForms();
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
