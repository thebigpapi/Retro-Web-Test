<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ChipDocumentation;
use App\Entity\Language;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ChipDocumentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link_name', TextType::class,[
                'label' => 'Title',
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'autocomplete' => true,
            ])
            ->add('manualFile', VichFileType::class, [
                'label' => 'PDF or ZIP file',
                'required' => false,
                'allow_delete' => false,
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChipDocumentation::class,
        ]);
    }
}
