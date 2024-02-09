<?php

namespace App\Controller\Admin\Type\ExpansionCard;

use App\Entity\ExpansionCardBios;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
            ->setColumns('col-sm-12 col-lg-12 col-xxl-6')
            ->onlyOnForms();
    }
}
