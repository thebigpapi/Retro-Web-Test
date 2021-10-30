<?php

namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Coprocessor;
use App\Form\Type\ProcessingUnitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class CoprocessorForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('processingUnit', ProcessingUnitType::class, [
                'data_class' => Coprocessor::class,
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coprocessor::class,
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort(
            $view->children['processingUnit']->children['fsb']->vars['choices'],
            function (ChoiceView $a, ChoiceView $b) {
                return ($a->data->getValue() > $b->data->getValue());
            }
        );
        usort(
            $view->children['processingUnit']->children['speed']->vars['choices'],
            function (ChoiceView $a, ChoiceView $b) {
                return ($a->data->getValue() > $b->data->getValue());
            }
        );
    }
}
