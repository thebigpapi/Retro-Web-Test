<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionSlot;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExpansionSlotCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionSlot::class;
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
