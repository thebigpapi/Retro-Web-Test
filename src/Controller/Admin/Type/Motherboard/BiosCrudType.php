<?php

namespace App\Controller\Admin\Type\Motherboard;

use App\Entity\MotherboardBios;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BiosCrudType extends AbstractCrudController
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
            ->setFormTypeOption('attr',['placeholder' => 'Type to select a manufacturer ...'])
            ->setColumns('col-sm-4 col-lg-4 col-xxl-2 padright');
        yield TextField::new('postString')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'POST string:'])
            ->setColumns('col-sm-8 col-lg-8 col-xxl-2-5 padright');
        yield TextField::new('note')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Note:'])
            ->setColumns('col-sm-4 col-lg-4 col-xxl-2-5 padright')
            ->onlyOnForms();
        yield TextField::new('boardVersion')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'BIOS version:'])
            ->setColumns('col-sm-4 col-lg-2 col-xxl-1 padright');
        yield TextField::new('coreVersion')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Core version:'])
            ->setColumns('col-sm-4 col-lg-1 col-xxl-1 padright');
        yield TextField::new('romFile')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('download_label',false)
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '32Mi',
                    'mimeTypes' => [
                        'application/x-binary',
                        'application/octet-stream',
                        'application/mac-binary',
                        'application/macbinary',
                        'application/x-macbinary',
                        'application/x-compressed',
                        'application/x-zip-compressed',
                        'application/zip',
                        'multipart/x-zip',
                        'application/x-lzh-compressed',
                        'application/x-dosexec',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid BIN, ZIP or EXE file',
                ])
            ])
            ->setColumns('col-sm-12 col-lg-5 col-xxl-2-5 padright')
            ->onlyOnForms();
    }
}
