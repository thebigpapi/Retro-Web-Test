<?php

namespace App\Controller\Admin\Type\Chip;

use App\Entity\ChipImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChipImage::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(6);
        yield TextField::new('imageFile', 'JPG or GIF')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '8192k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/pjpeg',
                        'image/gif',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid JPG or GIF image',
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
            ->setColumns(12);
        yield TextField::new('description', 'Notes')
            ->setColumns('col-sm-4 col-lg-4 col-xxl-4')
            ->setColumns(12);
    }
}