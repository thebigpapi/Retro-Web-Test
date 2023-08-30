<?php

namespace App\Controller\Admin;

use App\Entity\Processor;
use App\Form\Type\ChipAliasType;
use App\Form\Type\ChipImageType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorVoltageType;
use App\Form\Type\InstructionSetType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
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
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add('sockets')
            ->add('core')
            ->add('speed')
            ->add('fsb')
            ->add('tdp')
            ->add('ProcessNode');
    }


    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('info')
            ->onlyOnForms();
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('getManufacturer','Manufacturer')
            ->hideOnForm();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('placeholder', 'Select a manufacturer ...')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('partNumber', 'Name')
            ->setColumns(4);
        yield TextField::new('name', 'Aux Name')
            ->setColumns(4);
        yield ArrayField::new('getChipAliases', 'Aliases')
            ->hideOnForm();
        yield TextField::new('core', 'Core')
            ->hideOnForm();
        yield TextField::new('speed', 'Speed')
            ->hideOnForm();
        yield TextField::new('fsb', 'FSB')
            ->hideOnForm();
        yield IntegerField::new('tdp', 'TDP')
            ->hideOnForm();
        yield IntegerField::new('ProcessNode', 'Process')
            ->hideOnForm();
        yield ArrayField::new('getVoltages', 'Voltage')
            ->hideOnForm();
        yield AssociationField::new('platform', 'Family')
            ->setFormTypeOption('placeholder', 'Select a family ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield TextField::new('core', 'Core')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('speed','Speed')
            ->setFormTypeOption('placeholder', 'Select a speed ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('fsb','FSB')
            ->setFormTypeOption('placeholder', 'Select a speed ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('tdp', 'TDP (in W)')
            ->setColumns(2)
            ->onlyOnForms();
        yield NumberField::new('ProcessNode', 'Process (in nm)')
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
            ->setFormTypeOption('placeholder', 'Select a size ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L1CacheMethod','L1 method')
            ->setFormTypeOption('autocomplete', 'disabled')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L2','L2 size')
            ->setFormTypeOption('placeholder', 'Select a size ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L2CacheRatio','L2 ratio')
            ->setFormTypeOption('autocomplete', 'disabled')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L3','L3 size')
            ->setFormTypeOption('placeholder', 'Select a size ...')
            ->setColumns(2)
            ->onlyOnForms();
        yield AssociationField::new('L3CacheRatio','L3 ratio')
            ->setFormTypeOption('autocomplete', 'disabled')
            ->setColumns(2)
            ->onlyOnForms();
        yield FormField::addPanel('Other')->onlyOnForms();
        yield CollectionField::new('instructionSets', 'Instruction set')
            ->setEntryType(InstructionSetType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->setEntryType(ChipAliasType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ChipImageType::class)
            ->setColumns(12)
            ->renderExpanded()
            ->onlyOnForms();

    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined()->setPaginatorPageSize(100);
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
}
