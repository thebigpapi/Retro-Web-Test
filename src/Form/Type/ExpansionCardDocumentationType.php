<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\ExpansionCardDocumentation;
use App\Entity\Language;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ExpansionCardDocumentationType extends AbstractType
{
    /**
     * @return void
     */
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
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            ])
            ->add('releaseDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('datePrecision', ChoiceType::class, [
                'choices'  => [
                    'Year, month and day' => 'd',
                    'Year and month' => 'm',
                    'Year only' => 'y'
                ],
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

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpansionCardDocumentation::class,
        ]);
    }
}
