<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\MotherboardExpansionSlot;
use App\Entity\ExpansionSlot;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class MotherboardExpansionSlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expansion_slot', EntityType::class, [
                'class' => ExpansionSlot::class,
                'choice_label' => 'name',
                'label' => 'Type',
                'multiple' => false,
                'expanded' => false,
                'autocomplete' => true,
                ])
            ->add('count', NumberType::class,[
                'error_bubbling' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotherboardExpansionSlot::class,
        ]);
    }
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['expansion_slot']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
        });
    }
}
