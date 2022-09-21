<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\MotherboardImage;
use App\Entity\MotherboardImageType;
use App\Entity\Creditor;
use App\Entity\License;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class MotherboardImageTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file_name', TextType::class, [
                'required' => false,
                'disabled' => true,
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image (png, svg, jpg or gif file)',

                // unmapped means that this field is not associated to any entity property
                //'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
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
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('motherboardImageType', EntityType::class, [
                'class' => MotherboardImageType::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('creditor', EntityType::class, [
                'class' => Creditor::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'autocomplete' => true,
            ])
            ->add('license', EntityType::class, [
                'class' => License::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
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
