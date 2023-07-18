<?php

namespace App\Controller\Admin;

use App\Entity\ChipsetPart;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChipsetPartCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChipsetPart::class;
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
