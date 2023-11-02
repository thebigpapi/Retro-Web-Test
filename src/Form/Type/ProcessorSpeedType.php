<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\CpuSpeed;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class ProcessorSpeedType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => CpuSpeed::class,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            'choice_label' => 'getValueWithUnit',
            'multiple' => false,
            'expanded' => false,
            'placeholder'=> 'Type to select a speed ...',
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return ($a->data->getValue() <=> $b->data->getValue());
        });
    }
}
