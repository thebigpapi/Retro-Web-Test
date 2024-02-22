<?php

namespace App\Controller\Admin;

use App\Entity\MotherboardBios;
use Doctrine\ORM\EntityManagerInterface;
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

class MotherboardBiosCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MotherboardBios::class;
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
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/awchip.svg width=48 height=48>Motherboard BIOSes')
            ->setDefaultSort(['updated_at' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('postString')
            ->add('note')
            ->add('boardVersion')
            ->add('coreVersion')
            ->add('hash')
            ->add('updated_at');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield UrlField::new('motherboard.getId', 'Motherboard')
            ->setCustomOption('link','motherboards/')
            ->formatValue(function ($value, $entity) {
                return $entity->getMotherboard()->getPrettyTitle() ?: '[unknown]';
            })
            ->hideOnForm();
        yield AssociationField::new('motherboard')
            ->autocomplete()
            ->onlyOnForms();
        yield AssociationField::new('manufacturer', 'Vendor')
            ->autocomplete()
            ->setColumns(4);
        yield TextField::new('postString', 'POST string')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4');
        yield TextField::new('note')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('boardVersion', 'Version')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4');
        yield TextField::new('coreVersion', 'Core')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4');
        yield UrlField::new('file_name')
            ->setCustomOption('link','motherboard/bios/')
            ->hideOnForm();
        yield TextField::new('hash')
            ->setDisabled();
        yield TextField::new('romFile')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '32Mi',
                    'mimeTypes' => [
                        'application/x-binary',
                        'application/octet-stream',
                        'application/mac-binary',
                        'application/macbinary',
                        'application/x-macbinary',
                        'application/x-compressed',
                        'application/x-zip-compressed',
                        'application/zip',
                        'multipart/x-zip',
                        'application/x-lzh-compressed',
                        'application/x-dosexec',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid BIN, ZIP or EXE file',
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
    /**
     * @param MotherboardBios $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateHash();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
