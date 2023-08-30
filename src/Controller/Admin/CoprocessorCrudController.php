<?php

namespace App\Controller\Admin;

use App\Entity\Coprocessor;
use App\Form\Type\ChipAliasType;
use App\Form\Type\ChipImageType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\InstructionSetType;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
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
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(100);
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('getManufacturer','Manufacturer')
            ->hideOnForm();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('partNumber', 'Name')
            ->setColumns(4);
        yield TextField::new('name', 'Aux Name')
            ->setColumns(4);
        yield ArrayField::new('getChipAliases', 'Aliases')
            ->hideOnForm();
        yield TextField::new('getSpeedFSB', 'Speed/FSB')
            ->hideOnForm();
        yield AssociationField::new('platform', 'Family')
            ->setColumns(4)
            ->onlyOnForms();
        yield AssociationField::new('speed','Speed')
            ->setColumns(4)
            ->onlyOnForms();
        yield AssociationField::new('fsb','FSB')
            ->setColumns(4)
            ->onlyOnForms();
        yield CollectionField::new('sockets', 'Socket')
            ->setEntryType(CpuSocketType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addPanel('Other')->onlyOnForms();
        yield CollectionField::new('instructionSets', 'Instruction set')
            ->setEntryType(InstructionSetType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ChipImageType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->setEntryType(ChipAliasType::class)
            ->renderExpanded()
            ->onlyOnForms();
    }
}
