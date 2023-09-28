<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\AudioFile;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AudioFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Title',
            ])
            ->add('audioFile', VichFileType::class, [
                'label' => 'File',
                'allow_delete' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '64Mi',
                        'mimeTypes' => [
                            'audio/mpeg',
                            'audio/ogg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid audio file',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AudioFile::class,
        ]);
    }
}
