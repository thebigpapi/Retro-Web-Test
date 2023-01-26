<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ChipsetDocumentation;
use App\Entity\Language;

class ChipsetDocumentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file_name', TextType::class, [
                'required' => false,
                'disabled' => true,
            ])
            ->add('manualFile', FileType::class, [
                'label' => 'Manual (pdf/zip file)',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '32m',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/zip',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF or ZIP file',
                    ])
                ],
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                ])
            ->add('link_name', TextType::class);
            //->add('file_name', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChipsetDocumentation::class,
        ]);
    }
}
