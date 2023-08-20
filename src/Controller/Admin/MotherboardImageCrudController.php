<?php

namespace App\Controller\Admin;

use App\Entity\MotherboardImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MotherboardImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MotherboardImage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextField::new('file_name')
            ->setFormTypeOption('disabled','disabled');
        yield TextareaField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms();
    }
}
