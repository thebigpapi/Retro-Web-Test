<?php

namespace App\Controller\Admin;

use App\Entity\FormFactor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FormFactorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FormFactor::class;
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
