<?php

namespace App\Form\ExpansionChip;

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
            ->add('deviceId', TextType::class, [
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    return ['data_id' => $choice->getId() ];
                },
                'choices' => $options['expansionChipTypes'],
                'placeholder' => 'Type to select a type ...'
            ])
            ->add('expansionChipManufacturer', ChoiceType::class, [
                'choice_label' => 'getName',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data_id' => 'NULL' ];
                    return ['data_id' => $choice->getId() ];
                },
                'choices' => $options['expansionChipManufacturers'],
                'placeholder' => 'Type to select an expansion chip manufacturer ...',
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
            'expansionChipManufacturers' => array(),
            'expansionChipTypes' => array(),
        ]);
    }
}
