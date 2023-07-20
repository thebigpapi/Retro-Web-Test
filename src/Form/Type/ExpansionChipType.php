<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ExpansionChip;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class ExpansionChipType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => ExpansionChip::class,
            'choice_label' => 'getNameWithManufacturer',
            'multiple' => false,
            'expanded' => false,
            'autocomplete' => true,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
        });
    }
}
