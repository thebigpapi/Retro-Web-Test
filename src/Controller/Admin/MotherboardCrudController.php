<?php

namespace App\Controller\Admin;

use App\Entity\Motherboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
class MotherboardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Motherboard::class;
    }


    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();
        yield TextField::new('getManufacturerShortNameIfExist','Manufacturer')->hideOnForm();
        yield ChoiceField::new('getManufacturerShortNameIfExist','Manufacturer')->onlyOnForms();
        yield TextField::new('name');
        yield TextField::new('slug')->onlyOnForms();
        yield ArrayField::new('motherboardAliases')->onlyOnForms();
        //yield ChoiceField::new('getChipset')->autocomplete()->onlyOnForms();
        //yield ImageField::new('images')->onlyOnForms();
        yield TextField::new('dimensions');
        yield BooleanField::new('getManuals','Manual?')->renderAsSwitch(false)->hideOnForm();
        yield BooleanField::new('getMotherboardBios','BIOS?')->renderAsSwitch(false)->hideOnForm();
        yield TextEditorField::new('note')->onlyOnForms();
        yield DateField::new('lastEdited')->hideOnForm();

    }
    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

}
