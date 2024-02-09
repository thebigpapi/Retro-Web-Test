<?php

namespace App\Controller\Admin\Type\Motherboard;

use App\Entity\Manual;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ManualCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Manual::class;
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
        yield ChoiceField::new('datePrecision')
            ->setFormTypeOption('label',false)
            ->setChoices([
                'Year, month and day' => 'd',
                'Year and month' => 'm',
                'Year only' => 'y',
            ])
            ->setFormTypeOption('placeholder', 'Select a date format ...')
            ->renderAsNativeWidget()
            ->setColumns('col-sm-12 col-lg-12 col-xxl-4');
        yield DateField::new('releaseDate')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Core version:'])
            ->setColumns('col-sm-12 col-lg-12 col-xxl-8');
        yield TextField::new('manualFile', 'PDF file')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('download_label',false)
            ->setColumns(12)
            ->onlyOnForms();
    }
}