<?php

namespace App\Controller\Admin;

use App\Entity\LargeFile;
use App\Form\Type\LanguageType;
use App\Form\Type\OsFlagType;
use App\Form\Type\LargeFileMediaTypeFlagType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('fileVersion')
            ->add('file_name')
            ->add('subdirectory');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();

        yield TextField::new('name', 'Name');
        yield TextField::new('fileVersion', 'Version');
        yield TextField::new('file_name', 'File name')
            ->setFormTypeOption('disabled','disabled')
            ->onlyOnForms();
        yield DateField::new('release_date', 'Release Date');
        yield TextField::new('subdirectory', 'Type')
            ->onlyOnIndex();
        yield AssociationField::new('dumpQualityFlag','Quality')
            ->onlyOnForms();
        yield ChoiceField::new('subdirectory', 'Type')
            ->setChoices([
                'apps' => 'apps',
                'drivers' => 'drivers',
            ])
            ->onlyOnForms();
        yield CollectionField::new('languages', 'Language')
            ->setEntryType(LanguageType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('mediaTypeFlags', 'Media type flags')
            ->setEntryType(LargeFileMediaTypeFlagType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield ArrayField::new('mediaTypeFlags', 'Media type flags')
            ->onlyOnIndex();
        yield ArrayField::new('osFlags', 'OS flags')
            ->onlyOnIndex();
        yield CollectionField::new('osFlags', 'OS flags')
            ->setEntryType(OsFlagType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield DateField::new('lastEdited')
            ->hideOnForm();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
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
