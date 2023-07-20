<?php

namespace App\Controller\Admin;

use App\Entity\Processor;
use App\Form\Type\ChipAliasType;
use App\Form\Type\ChipImageType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorVoltageType;
use App\Form\Type\InstructionSetType;
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
        yield TextField::new('partNumber', 'Name');
        yield TextField::new('name', 'Aux Name');
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
        yield TextField::new('core', 'Core')
            ->onlyOnForms();
        yield AssociationField::new('speed','Speed')
            ->onlyOnForms();
        yield AssociationField::new('fsb','FSB')
            ->onlyOnForms();
        yield NumberField::new('tdp', 'TDP (in W)')
            ->onlyOnForms();
        yield NumberField::new('processNode', 'Process (in nm)')
            ->onlyOnForms();
        yield CollectionField::new('voltages', 'Voltage (in V)')
            ->setEntryType(ProcessorVoltageType::class)
            ->onlyOnForms();
        yield AssociationField::new('L1','L1 size')
            ->onlyOnForms();
        yield AssociationField::new('L1CacheMethod','L1 method')
            ->onlyOnForms();
        yield AssociationField::new('L2','L2 size')
            ->onlyOnForms();
        yield AssociationField::new('L2CacheRatio','L2 ratio')
            ->onlyOnForms();
        yield AssociationField::new('L3','L3 size')
            ->onlyOnForms();
        yield AssociationField::new('L3CacheRatio','L3 ratio')
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
