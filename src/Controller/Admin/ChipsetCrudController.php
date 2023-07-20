<?php

namespace App\Controller\Admin;

use App\Entity\Chipset;
use App\Form\Type\ChipsetPartType;
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

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('getManufacturer','Manufacturer')
            ->hideOnForm();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->onlyOnForms();
        yield TextField::new('part_no', 'Part number');
        yield TextField::new('name', 'Name');
        yield ArrayField::new('getParts', 'Parts')
            ->hideOnForm();
        yield CollectionField::new('chipsetParts', 'Parts')
            ->setEntryType(ChipsetPartType::class)
            ->onlyOnForms();
        yield UrlField::new('encyclopedia_link', 'Link')
            ->hideOnIndex();
        yield TextField::new('release_date', 'Release Date');
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
}
