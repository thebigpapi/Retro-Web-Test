<?php

namespace App\Controller\Admin\Type;

use App\Entity\MotherboardBios;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MotherboardBiosCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MotherboardBios::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('manufacturer', 'Manufacturer')
            ->autocomplete()
            ->setFormTypeOption('label',false)
            ->setColumns('col-sm-4 col-lg-4 col-xxl-2 padright');
        yield TextField::new('postString')
            ->setFormTypeOption('label',false)
            ->setColumns('col-sm-8 col-lg-8 col-xxl-2-5 padright');
        yield TextField::new('note')
            ->setFormTypeOption('label',false)
            ->setColumns('col-sm-4 col-lg-4 col-xxl-2-5 padright')
            ->onlyOnForms();
        yield TextField::new('boardVersion')
            ->setFormTypeOption('label',false)
            ->setColumns('col-sm-4 col-lg-2 col-xxl-1 padright');
        yield TextField::new('coreVersion')
            ->setFormTypeOption('label',false)
            ->setColumns('col-sm-4 col-lg-1 col-xxl-1 padright');
        yield TextField::new('romFile')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('download_label',false)
            ->setFormTypeOption('label',false)
            ->setColumns('col-sm-12 col-lg-5 col-xxl-2-5 padright')
            ->onlyOnForms();
    }
}
