<?php

namespace App\Controller\Admin\Type;

use App\Entity\MiscFile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MiscFileCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MiscFile::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('link_name')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Name:'])
            ->setColumns('col-sm-12 col-lg-12 col-xxl-4');
        yield TextField::new('miscFile')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '64Mi',
                ])
            ])
            ->setColumns('col-sm-12 col-lg-12 col-xxl-8')
            ->onlyOnForms();
    }
}
