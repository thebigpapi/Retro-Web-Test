<?php

namespace App\Controller\Admin;

use App\Entity\Creditor;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CreditorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Creditor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name');
        yield TextField::new('website', 'Website');
        /*yield ArrayField::new('license', 'License')
            ->onlyOnIndex();
        yield AssociationField::new('license', 'License')
            ->onlyOnForms(); broken */
        yield NumberField::new('getMoboImg', 'Mobo img')
            ->onlyOnIndex();
        yield NumberField::new('getChipImg', 'Chip img')
            ->onlyOnIndex();
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined();
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
}
