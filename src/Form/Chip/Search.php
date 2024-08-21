<?php

namespace App\Form\Chip;

use App\Form\Type\CpuSocketType;
use App\Form\Type\ItemsPerPageType;
use App\Form\Type\ProcessorPlatformTypeForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

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
            ->add('deviceId', TextType::class, [
                'required' => false,
            ])
            ->add('processNode', IntegerType::class, [
                'required' => false,
            ])
            ->add('tdp', IntegerType::class, [
                'required' => false,
                /*"constraints" => [new Assert\Positive]*/
            ])
            ->add('type', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['chipTypes'],
                'placeholder' => 'Type to select a type ...'
            ])
            ->add('chipManufacturer', ChoiceType::class, [
                'choice_label' => 'getName',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data-id' => 'NULL' ];
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['chipManufacturers'],
                'placeholder' => 'Type to select a chip manufacturer ...',
            ])
            ->add('sockets', CollectionType::class, [
                'entry_type' => CpuSocketType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('families', CollectionType::class, [
                'entry_type' => ProcessorPlatformTypeForm::class,
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
            'chipManufacturers' => array(),
            'chipTypes' => array(),
        ]);
    }
}
