<?php

namespace App\Controller\Admin\Type\ExpansionCard;

use App\Entity\ExpansionCardIoPort;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class IoPortInterfaceSignalCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCardIoPort::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('count')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Count:'])
            ->addCssClass('count-css')
            ->setColumns('col-4 col-sm-3 col-lg-4 col-xxl-3 nopadright');
        yield AssociationField::new('ioPortInterfaceSignal', 'Preset')
            ->autocomplete()
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Preset:'])
            ->setColumns('col-8 col-sm-9 col-lg-8 col-xxl-9 nopadleft');
        yield AssociationField::new('ioPortInterface', 'Connector')
            ->autocomplete()
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Connector:'])
            ->setColumns(12);
        yield AssociationField::new('ioPortSignals', 'Signals')
            ->autocomplete()
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Signals:'])
            ->setColumns(12);
        yield BooleanField::new('isinternal', 'Internal port');
    }
}