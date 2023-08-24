<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\IoPort;
use App\Entity\MotherboardIoPort;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class MotherboardIoPortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('io_port', EntityType::class, [
                'class' => IoPort::class,
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
            'data_class' => MotherboardIoPort::class,
        ]);
    }
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['io_port']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
        });
    }
}
