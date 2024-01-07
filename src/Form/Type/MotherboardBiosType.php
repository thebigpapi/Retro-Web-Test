<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Manufacturer;
use App\Entity\MotherboardBios;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MotherboardBiosType extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Type to select a manufacturer ...',
            ])
            ->add('postString', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'POST string:'],
            ])
            ->add('note', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Note:'],
            ])
            ->add('boardVersion', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'BIOS version:'],
            ])
            ->add('coreVersion', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Core version:'],
            ])
            ->add('romFile', VichFileType::class, [
                'label' => false,
                'required' => false,
                'allow_delete' => false,
                'download_label' => false,
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
            ]);
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotherboardBios::class,
        ]);
    }
}
