<?php

namespace App\Controller\Admin;

use App\Entity\Chipset;
use App\Form\Type\ChipsetAliasType;
use App\Form\Type\ChipsetBiosCodeType;
use App\Form\Type\ChipsetDocumentationType;
use App\Form\Type\ChipsetPartType;
use App\Form\Type\LargeFileChipsetType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChipsetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chipset::class;
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('part_no')
            ->add('chipsetParts')
            ->add('release_date')
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('getManufacturer','Manufacturer')
            ->hideOnForm();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('part_no', 'Part number')
            ->setColumns(4);
        yield TextField::new('name', 'Name')
            ->setColumns(4);
        yield ArrayField::new('getParts', 'Parts')
            ->hideOnForm();
        yield TextField::new('release_date', 'Release Date')
            ->setColumns(4);
        yield UrlField::new('encyclopedia_link', 'Link')
            ->setColumns(4)
            ->hideOnIndex();
        yield DateField::new('lastEdited', 'Last edit')
            ->setFormTypeOption('disabled', 'disabled')
            ->setColumns(4);
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield CollectionField::new('chipsetParts', 'Parts')
            ->setEntryType(ChipsetPartType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('chipsetAliases', 'Chipset aliases')
            ->setEntryType(ChipsetAliasType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('biosCodes', 'BIOS codes')
            ->setEntryType(ChipsetBiosCodeType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->setEntryType(ChipsetDocumentationType::class)
            ->renderExpanded()
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileChipsetType::class)
            ->renderExpanded()
            ->setColumns(6)
            ->onlyOnForms();
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    /**
     * @param Chipset $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPaginatorPageSize(100)
            ->setDefaultSort(['lastEdited' => 'DESC']);
    }
}
