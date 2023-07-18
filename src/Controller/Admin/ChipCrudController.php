<?php

namespace App\Controller\Admin;

use App\Entity\Chip;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chip::class;
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
