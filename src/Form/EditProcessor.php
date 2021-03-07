<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\ProcessingUnitType;
use App\Entity\Processor;
use App\Entity\CacheSize;
use App\Entity\CacheMethod;
use App\Entity\CacheRatio;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EditProcessor extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('processingUnit', ProcessingUnitType::class, [
                'data_class' => Processor::class,
            ])
            ->add('core', TextType::class, [
                'required' => false,
            ])
            ->add('voltage', NumberType::class, [
                'required' => true,
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
            ->add('L1CacheMethod', EntityType::class, [
                'class' => CacheMethod::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Select a cache method ...',
                'required' => false,
            ])
            ->add('L2CacheRatio', EntityType::class, [
                'class' => CacheRatio::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Select a cache ratio ...',
                'required' => false,
            ])
            ->add('L3CacheRatio', EntityType::class, [
                'class' => CacheRatio::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Select a cache ratio ...',
                'required' => false,
            ])
            
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Processor::class,
        ]);
    }
}