<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionCardImage;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ExpansionCardImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCardImage::class;
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
            ->setPaginatorPageSize(50)
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/search_image.svg width=48 height=48>Expansion card images');
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('creditor')
            ->add('type')
            ->add('description')
            ->add('updated_at');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('expansionCard')->hideOnForm();
        yield AssociationField::new('expansionCard')
            ->autocomplete()
            ->onlyOnForms();
        yield AssociationField::new('creditor', 'Creditor')
            ->autocomplete()
            ->setColumns(4);
        yield ChoiceField::new('type')
            ->setColumns('col-sm-6 col-lg-6 col-xxl-4')
            ->setFormTypeOption('choices', [
                'Schema' => '1',
                'Photo front' => '2',
                'Photo back' => '3',
                'Photo misc' => '4',
                'Schema misc' => '5',
            ])
            ->onlyOnForms();
        yield TextField::new('description', 'Notes')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4');
        yield ImageField::new('file_name', 'Image')
            ->setCustomOption('link','expansioncard/image')
            ->setCustomOption('thumb_link','media/cache/show_thumb/expansioncard/image')
            ->hideOnForm();
        yield TextField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete',false)
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
