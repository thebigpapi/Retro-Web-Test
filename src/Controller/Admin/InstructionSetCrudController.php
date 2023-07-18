<?php

namespace App\Controller\Admin;

use App\Entity\InstructionSet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InstructionSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InstructionSet::class;
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
