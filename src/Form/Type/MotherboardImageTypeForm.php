<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\MotherboardImage;
use App\Entity\MotherboardImageType;
use App\Entity\Creditor;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MotherboardImageTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'JPG or SVG file',
                'allow_delete' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '8192k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/pjpeg',
                            'image/png',
                            'image/gif',
                            'image/svg+xml',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('creditor', EntityType::class, [
                'class' => Creditor::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder'=> 'Select a creditor ...',
            ])
            ->add('motherboardImageType', EntityType::class, [
                'class' => MotherboardImageType::class,
                'label' => 'Type',
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder'=> 'Select a type ...',
            ])
            ->add('description', TextType::class, [
                'label' => 'Note',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotherboardImage::class,
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['creditor']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
        });
    }
}
