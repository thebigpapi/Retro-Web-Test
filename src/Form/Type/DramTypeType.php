<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\DramType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class DramTypeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => DramType::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
            'autocomplete' => true,
            'placeholder'=> 'Select a RAM type ...',
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return ($a->data->getName() <=> $b->data->getName());
        });
    }
}
