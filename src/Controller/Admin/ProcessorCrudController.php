<?php

namespace App\Controller\Admin;

use App\Entity\Processor;
use App\Form\Type\ChipAliasType;
use App\Form\Type\ChipImageType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorVoltageType;
use App\Form\Type\InstructionSetType;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProcessorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Processor::class;
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
        yield ArrayField::new('chipAliases', 'Aliases')
            ->hideOnForm();
        yield TextField::new('core', 'Core')
            ->hideOnForm();
        yield TextField::new('getSpeedFSB', 'Speed/FSB')
            ->hideOnForm();
        yield ArrayField::new('getVoltages', 'Voltage')
            ->hideOnForm();
        yield ArrayField::new('getTdpWithValue', 'TDP')
            ->hideOnForm();
        yield AssociationField::new('platform', 'Family')
            ->setColumns(2)
            ->onlyOnForms();
        yield TextField::new('core', 'Core')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('speed','Speed')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('fsb','FSB')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('tdp', 'TDP (in W)')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('processNode', 'Process (in nm)')
            ->setColumns(2)
            ->onlyOnForms();
        yield CollectionField::new('sockets', 'Socket')
            ->setEntryType(CpuSocketType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('voltages', 'Voltage (in V)')
            ->setEntryType(ProcessorVoltageType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addPanel('Cache')->onlyOnForms();
        yield AssociationField::new('L1','L1 size')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L1CacheMethod','L1 method')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L2','L2 size')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L2CacheRatio','L2 ratio')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L3','L3 size')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L3CacheRatio','L3 ratio')
            ->setColumns(2)
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
