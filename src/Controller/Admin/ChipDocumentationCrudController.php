<?php

namespace App\Controller\Admin;

use App\Entity\ChipDocumentation;
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
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ChipDocumentationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChipDocumentation::class;
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
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100)
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/manual.svg width=48 height=48>Chip documentation')
            ->setDefaultSort(['updated_at' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('link_name')
            ->add('language')
            ->add('updated_at');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield UrlField::new('chip.getId', 'Chip')
            ->setCustomOption('link','chip/')
            ->formatValue(function ($value, $entity) {
                return $entity->getChip()->getFullName() ?: '[unknown]';
            })
            ->hideOnForm();
        yield AssociationField::new('chip')
            ->autocomplete()
            ->setDisabled()
            ->onlyOnForms();
        yield TextField::new('link_name', 'Title')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4');
        yield AssociationField::new('language', 'Language')
            ->setColumns(4);
        yield UrlField::new('file_name')
            ->setCustomOption('link','chip/documentation/')
            ->hideOnForm();
        yield TextField::new('manualFile')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '32Mi',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ])
            ])
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4')
            ->onlyOnForms();
        yield DateField::new('updated_at', 'Last edited')
            ->hideOnForm();
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
}
