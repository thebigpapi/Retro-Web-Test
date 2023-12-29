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
use App\Entity\Manual;
use App\Entity\Language;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ManualType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link_name', TextType::class, [
                'label' => 'Title',
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
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
                'label' => 'PDF file',
                'allow_delete' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '32Mi',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Manual::class,
        ]);
    }

    /*public function upload()
    {
        // ...

        if ($form->isSubmitted() && $form->isValid()) {
            $someNewFilename = "test.pdf";
            $directory = '/motherboard/manual/';

            $file = $form['attachment']->getData();
            $file->move($directory, $someNewFilename);

            // ...
        }

        // ...
    }*/
}
