<?php

namespace App\Form\ExpansionCard;

use App\Form\Type\DramTypeType;
use App\Form\Type\ExpansionCardTypeType;
use App\Form\Type\ItemsPerPageType;
use App\Form\Type\ChipType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Search extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('manufacturer', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data-id' => 'NULL' ];
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['expansionCardManufacturers'],
                'placeholder' => 'Type to select a manufacturer ...'
            ])
            ->add('cardTypes', CollectionType::class, [
                'entry_type' => ExpansionCardTypeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('chips', CollectionType::class, [
                'entry_type' => ChipType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('dramTypes', CollectionType::class, [
                'entry_type' => DramTypeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('cardExpansionSlot', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['expansionCardExpansionSlots'],
                'placeholder' => 'Type to select an expansion slot ...'
            ])
            ->add('cardIoPorts', CollectionType::class, [
                'entry_type' => IoPortSearchType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('itemsPerPage', EnumType::class, [
                'class' => ItemsPerPageType::class,
                'empty_data' => ItemsPerPageType::Items100,
                'choice_label' => fn ($choice) => strval($choice->value),
            ]);
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'expansionCardManufacturers' => array(),
            'expansionCardTypes' => array(),
            'expansionCardExpansionSlots' => array(),
        ]);
    }
}
