<?php

namespace App\Controller\Admin;

use App\Entity\ProcessorPlatformType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProcessorPlatformTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProcessorPlatformType::class;
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
