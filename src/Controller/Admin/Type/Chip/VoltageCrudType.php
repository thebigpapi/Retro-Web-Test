<?php

namespace App\Controller\Admin\Type\Chip;

use App\Entity\ProcessorVoltage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VoltageCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProcessorVoltage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('value')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Value (in Volts):'])
            ->setColumns(12);
    }
}