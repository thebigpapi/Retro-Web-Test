<?php

namespace App\Controller\Admin;

use App\Entity\Chipset;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChipsetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chipset::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
