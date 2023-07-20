<?php

namespace App\Controller\Admin;

use App\Entity\Coprocessor;
use App\Form\Type\ChipAliasType;
use App\Form\Type\ChipImageType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\InstructionSetType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CoprocessorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coprocessor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('getManufacturer','Manufacturer')
            ->hideOnForm();
        yield TextField::new('partNumber', 'Name');
        yield TextField::new('name', 'Aux Name');
        yield ArrayField::new('chipAliases', 'Aliases')
            ->hideOnForm();
        yield TextField::new('getSpeedFSB', 'Speed/FSB')
            ->hideOnForm();
        // editor
        yield AssociationField::new('manufacturer','Manufacturer')
            ->onlyOnForms();
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->setEntryType(ChipAliasType::class)
            ->onlyOnForms();
        yield CollectionField::new('sockets', 'Socket')
            ->setEntryType(CpuSocketType::class)
            ->onlyOnForms();
        yield AssociationField::new('platform', 'Family')
            ->onlyOnForms();
        yield AssociationField::new('speed','Speed')
            ->onlyOnForms();
        yield AssociationField::new('fsb','FSB')
            ->onlyOnForms();
        yield CollectionField::new('instructionSets', 'Instruction set')
            ->setEntryType(InstructionSetType::class)
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ChipImageType::class)
            ->onlyOnForms();
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
