<?php

namespace App\Controller\Admin\Type\Chip;

use App\Entity\CPUID;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CPUIDCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CPUID::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('value')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'CPUID:']);
    }
}