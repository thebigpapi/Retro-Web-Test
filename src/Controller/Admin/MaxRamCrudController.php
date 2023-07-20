<?php

namespace App\Controller\Admin;

use App\Entity\MaxRam;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MaxRamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaxRam::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield NumberField::new('value');
    }

}
