<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\InstructionSet;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class InstructionSetType extends AbstractType
{
    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chipset_part', EntityType::class, [
                'class' => ChipsetPart::class,
                'choice_label' => 'getFullName',
                'multiple' => false,
                'expanded' => false,
                ])
            ->add('index',NumberType::class, [
                'required' => true,
            ]);
    }*/

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => InstructionSet::class,
            'choice_label' => 'getName',
            'multiple' => false,
            'expanded' => false,
        ]);
    }

    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChipsetChipsetPart::class,
        ]);
    }*/
    public function getParent(): ?string
    {
        return EntityType::class;
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return ($a->data->getName() > $b->data->getName());
        });
    }
}
