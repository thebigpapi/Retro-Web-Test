<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\MaxRam;
use App\Entity\MotherboardMaxRam;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class MotherboardMaxRamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('max_ram', EntityType::class, [
                'class' => MaxRam::class,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
                ])
            ->add('note', TextType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotherboardMaxRam::class,
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['max_ram']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return ($a->data->getValue() > $b->data->getValue());
        });
    }
}
