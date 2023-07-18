<?php

namespace App\Controller\Admin;

use App\Entity\PSUConnector;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PSUConnectorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PSUConnector::class;
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
