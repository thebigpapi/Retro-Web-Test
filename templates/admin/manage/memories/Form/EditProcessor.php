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
use App\Form\Type\ProcessorVoltageType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

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
            ->add('voltages', CollectionType::class, [
                'entry_type' => ProcessorVoltageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('tdp', NumberType::class, [
                'required' => false,
            ])
            ->add('processNode', NumberType::class, [
                'required' => false,
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

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['processingUnit']->children['fsb']->vars['choices'], function(ChoiceView $a, ChoiceView $b) {
            return ($a->data->getValue() > $b->data->getValue());
        });
        usort($view->children['processingUnit']->children['speed']->vars['choices'], function(ChoiceView $a, ChoiceView $b) {
            return ($a->data->getValue() > $b->data->getValue());
        });
    }
}