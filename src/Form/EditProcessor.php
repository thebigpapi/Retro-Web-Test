<?php
namespace App\Form;

use App\Entity\CpuSpeed;
use App\Entity\InstructionSet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\InstructionSetType;
use App\Entity\Processor;
use App\Entity\ProcessorPlatformType;
use App\Entity\Manufacturer;
use App\Entity\CacheSize;

class EditProcessor extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['processorManufacturers'],
            ])
            ->add('speed', EntityType::class, [
                'class' => CpuSpeed::class,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('partNumber', TextType::class, [
                'required' => false,
            ])
            ->add('platform', EntityType::class, [
                'class' => ProcessorPlatformType::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('fsb', EntityType::class, [
                'class' => CpuSpeed::class,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('L1', EntityType::class, [
                'class' => CacheSize::class,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Select a cache size ...',
                'required' => false,
            ])
            ->add('L2', EntityType::class, [
                'class' => CacheSize::class,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Select a cache size ...',
                'required' => false,
            ])
            ->add('L3', EntityType::class, [
                'class' => CacheSize::class,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Select a cache size ...',
                'required' => false,
            ])
            ->add('instructionSets', CollectionType::class, [
                'entry_type' => InstructionSetType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options'  => [
                    'choices' => $options['instructionSets'],
                ],
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Processor::class,
            'processorManufacturers' => array(),
            'instructionSets' => array(),
        ]);
    }
}