<?php

namespace App\Controller\Admin\Type\StorageDevice;

use App\Entity\StorageDeviceDocumentation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DocumentationCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StorageDeviceDocumentation::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('language', 'Language')
            ->setFormTypeOption('label',false)
            ->setColumns('col-sm-12 col-lg-12 col-xxl-4');
        yield TextField::new('link_name')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Title:'])
            ->setColumns('col-sm-12 col-lg-12 col-xxl-8');
        yield TextField::new('manualFile', 'PDF file')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '32Mi',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ])
            ])
            ->setColumns(12)
            ->onlyOnForms();
        yield DateField::new('releaseDate', 'Release date')
            ->renderAsText()
            ->setColumns(12);
        yield ChoiceField::new('datePrecision')
            ->setFormTypeOption('label',false)
            ->setChoices([
                'Year, month and day' => 'd',
                'Year and month' => 'm',
                'Year only' => 'y',
            ])
            ->setFormTypeOption('placeholder', 'Select a date format ...')
            ->renderAsNativeWidget()
            ->setColumns(1);
    }
}