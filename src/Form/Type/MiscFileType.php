<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\MiscFile;
use App\Entity\Language;

class MiscFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file_name', TextType::class, [
                'required' => false,
                'disabled' => true,
            ])
            ->add('miscFile', FileType::class, [
                'label' => 'Misc file',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '16Mi',
                    ])
                ],
            ])
            ->add('link_name', TextType::class);
            //->add('file_name', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MiscFile::class,
        ]);
    }
}
