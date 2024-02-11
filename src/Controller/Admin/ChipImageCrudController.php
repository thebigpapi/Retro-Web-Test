<?php

namespace App\Controller\Admin;

use App\Entity\ChipImage;
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
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ChipImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChipImage::class;
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
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/search_image.svg width=48 height=48>Chip images');
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('creditor')
            ->add('description')
            ->add('updated_at');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('chip')->hideOnForm();
        yield AssociationField::new('chip')
            ->autocomplete()
            ->onlyOnForms();
        yield AssociationField::new('creditor', 'Creditor')
            ->autocomplete()
            ->setColumns(4);
        yield TextField::new('description', 'Notes')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4');
        yield ImageField::new('file_name', 'Image')
            ->setCustomOption('link','chip/image')
            ->setCustomOption('thumb_link','media/cache/show_thumb/chip/image')
            ->hideOnForm();
        yield TextField::new('imageFile', 'JPG or GIF')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '8192k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/pjpeg',
                        'image/gif',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid JPG or GIF image',
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
