<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Manufacturer;
use App\Entity\MotherboardBios;

class MotherboardBiosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file_name', TextType::class, [
                'required' => false,
                'disabled' => true,
            ])
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'autocomplete' => true,
                'placeholder' => 'n/a'
            ])
            ->add('romFile', FileType::class, [
                'label' => 'BIOS (bin, zip or exe file)',

                // unmapped means that this field is not associated to any entity property
                //'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '16m',
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
                ],
            ])
            ->add('postString', TextType::class, [
                'required' => false,
            ])
            ->add('note', TextType::class, [
                'required' => false,
            ])
            ->add('boardVersion', TextType::class, [
                'required' => false,
            ])
            ->add('coreVersion', TextType::class, [
                'required' => false,
            ]);
            //->add('file_name', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotherboardBios::class,
        ]);
    }
}
