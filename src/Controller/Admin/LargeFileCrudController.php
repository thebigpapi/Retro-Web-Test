<?php

namespace App\Controller\Admin;

use App\Entity\LargeFile;
use App\Form\Type\LanguageType;
use App\Form\Type\OsFlagType;
use App\Form\Type\LargeFileMediaTypeFlagType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LargeFileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LargeFile::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $view = Action::new('view', 'View')->linkToCrudAction('viewDriver');
        return $actions
            ->add(Crud::PAGE_INDEX, $view)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100)
            ->overrideTemplate('crud/edit', 'admin/crud/edit_driver.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new_driver.html.twig')
            ->setDefaultSort(['lastEdited' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('fileVersion')
            ->add('file_name')
            ->add('subdirectory')
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name', 'Name')
            ->setColumns(4);
        yield TextField::new('fileVersion', 'Version')
            ->setColumns(4);
        yield ChoiceField::new('subdirectory', 'Type')
            ->setChoices([
                'apps' => 'apps',
                'drivers' => 'drivers',
            ])
            ->setFormTypeOption('empty_data', 'drivers')
            ->setFormTypeOption('autocomplete', 'disabled')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('subdirectory', 'Type')
            ->onlyOnIndex();
        yield AssociationField::new('dumpQualityFlag','Quality')
            ->setColumns(4)
            ->onlyOnForms();
        yield DateField::new('release_date', 'Release Date')
            ->setColumns(4);
        yield TextareaField::new('file', 'File')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete', false)
            //->setFormTypeOption('download_label', false)
            ->setColumns(4)
            ->onlyOnForms();
        yield CollectionField::new('languages', 'Language')
            ->setEntryType(LanguageType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('mediaTypeFlags', 'Media type flags')
            ->setEntryType(LargeFileMediaTypeFlagType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('getMediaTypeFlags', 'Media type flags')
            ->onlyOnIndex();
        yield ArrayField::new('getOsFlags', 'OS flags')
            ->onlyOnIndex();
        yield CollectionField::new('osFlags', 'OS flags')
            ->setEntryType(OsFlagType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield DateField::new('lastEdited')
            ->hideOnForm();
    }
    public function viewDriver(AdminContext $context)
    {
        $driverId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('driver_show', array('id'=>$driverId));
    }
    /**
     * @param LargeFile $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
