<?php

namespace App\Form\ExpansionCard;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ExpansionCardType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class ExpansionCardTypeType extends AbstractType
{

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => ExpansionCardType::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            'placeholder'=> 'Type to select a type ...',
        ]);
    }
    public function getParent(): ?string
    {
        return EntityType::class;
    }
    /**
     * @return void
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return ($a->data->getName() <=> $b->data->getName());
        });
    }
}