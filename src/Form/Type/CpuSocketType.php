<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\CpuSocket;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class CpuSocketType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => CpuSocket::class,
            'choice_label' => 'getNameAndType',
            'multiple' => false,
            'expanded' => false,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            'placeholder'=> 'Select a CPU socket ...',
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            if (!$a->data->getName() && !$b->data->getName()) {
                return strnatcasecmp($a->data->getType() ?? '', $b->data->getType() ?? '');
            } else {
                return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
            }
        });
    }
}
