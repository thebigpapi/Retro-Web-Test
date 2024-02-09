<?php

namespace App\Controller\Admin\Type\Motherboard;

use App\Entity\MotherboardMaxRam;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MaxRamCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MotherboardMaxRam::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('max_ram', 'Max Ram')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('placeholder', 'RAM size...')
            ->setColumns('col-sm-12 col-lg-6 col-xxl-6');
        yield TextField::new('note', 'Note')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Note:'])
            ->setColumns('col-sm-12 col-lg-6 col-xxl-6');
    }
}