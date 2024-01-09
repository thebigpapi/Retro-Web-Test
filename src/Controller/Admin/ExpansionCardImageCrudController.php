<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionCardImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ExpansionCardImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCardImage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('creditor','Creditor');
        yield TextField::new('description', 'Note');
    }
}
