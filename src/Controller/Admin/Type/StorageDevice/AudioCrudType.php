<?php

namespace App\Controller\Admin\Type\StorageDevice;

use App\Entity\AudioFile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AudioCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AudioFile::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Name:'])
            ->setColumns('col-sm-12 col-lg-12 col-xxl-4');
        yield TextField::new('audioFile')
            ->setFormType(VichFileType::class)
            ->setFormTypeOption('allow_delete',false)
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('constraints',[
                new File([
                    'maxSize' => '64Mi',
                    'mimeTypes' => [
                        'audio/mpeg',
                        'audio/ogg',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid audio file',
                ])
            ])
            ->setColumns('col-sm-12 col-lg-12 col-xxl-8')
            ->onlyOnForms();
    }
}
