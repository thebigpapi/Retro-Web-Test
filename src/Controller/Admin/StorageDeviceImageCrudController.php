<?php

namespace App\Controller\Admin;

use App\Entity\StorageDeviceImage;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;
class StorageDeviceImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StorageDeviceImage::class;
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
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/search_image.svg width=48 height=48>Storage device images')
            ->setDefaultSort(['updated_at' => 'DESC']);
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
        yield UrlField::new('storageDevice.getId', 'Storage device')
            ->setCustomOption('link','storage/')
            ->formatValue(function ($value, $entity) {
                return $entity->getStorageDevice()->getNameWithManufacturer() ?: '[unknown]';
            })
            ->hideOnForm();
        yield AssociationField::new('storageDevice')
            ->setDisabled()
            ->onlyOnForms();
        yield AssociationField::new('creditor', 'Creditor')
            ->autocomplete()
            ->setColumns(4);
        yield ChoiceField::new('type', 'Type')
            ->setFormTypeOption('choices', [
                'Schema' => '1',
                'Top photo' => '2',
                'Bottom photo' => '5',
                'Front photo' => '3',
                'Back photo' => '4',
                'Misc' => '6',
            ])
            ->setColumns(4);
        yield TextField::new('description', 'Notes')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4');
        yield ImageField::new('file_name', 'Image')
            ->setCustomOption('link','storage/image')
            ->setCustomOption('thumb_link','media/cache/show_thumb/storage/image')
            ->hideOnForm();
        yield TextField::new('imageFile', 'JPG, GIF or SVG')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '8192k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/pjpeg',
                        'image/gif',
                        'image/svg+xml',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid JPG, GIF or SVG image',
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
