<?php

namespace App\Controller\Admin\Type;

use App\Entity\EntityImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EntityImageCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EntityImage::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(6);
        yield TextField::new('imageFile', 'JPG, PNG, GIF or SVG')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '8192ki',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/pjpeg',
                        'image/png',
                        'image/gif',
                        'image/svg+xml',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid JPG, PNG, GIF or SVG image',
                ])
            ])
            ->setColumns(12)
            ->onlyOnForms();
        yield FormField::addColumn(6);
        yield AssociationField::new('creditor', 'Creditor')
            ->autocomplete()
            ->setFormTypeOption('attr',['placeholder' => 'Type to select a creditor ...'])
            ->setColumns(12);
        yield NumberField::new('sort', 'Sort position')
            ->setFormTypeOption('required', true)
            ->setFormTypeOption('empty_data', '1')
            ->setColumns(12);
        yield TextField::new('description', 'Notes')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4')
            ->setColumns(12);
    }
}