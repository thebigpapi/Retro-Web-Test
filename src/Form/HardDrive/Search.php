<?php

namespace App\Form\HardDrive;

use App\Form\Type\ItemsPerPageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class Search extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('partNumber', TextType::class, [
                'required' => false,
            ])
            ->add('capacity', TextType::class, [
                'required' => false,
            ])
            ->add('hddManufacturer', ChoiceType::class, [
                'choice_label' => 'getName',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data_id' => 'NULL' ];
                    return ['data_id' => $choice->getId() ];
                },
                'choices' => $options['hddManufacturers'],
                'placeholder' => 'Type to select a hard drive manufacturer ...',
            ])
            ->add('itemsPerPage', EnumType::class, [
                'class' => ItemsPerPageType::class,
                'empty_data' => ItemsPerPageType::Items100,
                'choice_label' => fn ($choice) => strval($choice->value),
            ])
            ->add('searchWithImages', CheckboxType::class, [
                'data' => true,
                'label' => false,
                'attr' => array('checked' => 'checked'),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'hddManufacturers' => array(),
        ]);
    }
}
