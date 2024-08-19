<?php

namespace App\Form\Processor;

use App\Entity\Processor;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorPlatformTypeForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use App\Form\Type\ItemsPerPageType;

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
            ->add('cpuManufacturer', ChoiceType::class, [
                'choice_label' => 'getName',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data-id' => 'NULL' ];
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['cpuManufacturers'],
                'placeholder' => 'Type to select a CPU manufacturer ...',
            ])
            ->add('cpuSpeed', ChoiceType::class, [
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['cpuSpeeds'],
                'placeholder' => 'Type to select a CPU frequency ...',
            ])
            ->add('fsbSpeed', ChoiceType::class, [
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['cpuSpeeds'],
                'placeholder' => 'Type to select a bus speed ...',
            ])
            ->add('sockets', CollectionType::class, [
                'entry_type' => CpuSocketType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('platforms', CollectionType::class, [
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
            'cpuManufacturers' => array(),
            'cpuSpeeds' => array(),
        ]);
    }
}
