<?php

namespace App\Form\Bios;

use App\Entity\Chipset;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class Search extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        usort($options['chipsets'], function ($a, $b) {
            return strnatcasecmp($a->getFullName(), $b->getFullName());
        });
        
        $builder
            ->add('post_string', TextType::class, [
                'required' => false,
            ])
            ->add('core_version', TextType::class, [
                'required' => false,
            ])
            ->add('chipset', ChoiceType::class, [
                'choice_label' => 'getFullNameParts',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['chipsets'],
                'placeholder' => 'Select a chipset ...',
            ])

            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,

                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['biosManufacturers'],
                'placeholder' => 'Select a manufacturer ...',
            ])
            ->add('file_present', CheckboxType::class, [
                'label'    => 'File is present ?',
                'required' => false,
            ])
            ->add('search', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'biosManufacturers' => array(),
            'chipsets' => array(),
        ]);
    }
}
