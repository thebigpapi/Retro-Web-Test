<?php

namespace App\Controller\Admin;

use App\Entity\MediaTypeFlag;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaTypeFlagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MediaTypeFlag::class;
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
