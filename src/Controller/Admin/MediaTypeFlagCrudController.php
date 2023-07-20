<?php

namespace App\Controller\Admin;

use App\Entity\MediaTypeFlag;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaTypeFlagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MediaTypeFlag::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name');
        yield TextField::new('tagName');
        yield TextField::new('file_name');
        yield TextareaField::new('icon')->setFormType(VichImageType::class)->onlyOnForms();
    }
}
