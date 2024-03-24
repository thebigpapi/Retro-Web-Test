<?php

namespace App\Controller\Admin\Type\ExpansionCard;

use App\Entity\ExpansionCardBios;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BiosCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCardBios::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('note')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Note:'])
            ->setColumns('col-sm-12 col-lg-8 col-xxl-4')
            ->onlyOnForms();
        yield TextField::new('version')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'BIOS version:'])
            ->setColumns('col-sm-12 col-lg-4 col-xxl-2');
        yield TextField::new('romFile')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            //->setFormTypeOption('download_label',false)
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
                        'application/x-ibm-rom',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid BIN, ZIP or EXE file',
                ])
            ])
            ->setColumns('col-sm-12 col-lg-12 col-xxl-6')
            ->onlyOnForms();
    }
}
