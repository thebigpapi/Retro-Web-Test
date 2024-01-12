<?php

namespace App\Form\Type;

use App\Entity\ExpansionCardIoPort;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\IoPortInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Entity\IoPortSignal;

class ExpansionCardIoPortType extends AbstractType
{

    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', NumberType::class,[
                'label' => 'Count',
            ])
            ->add('ioPortInterface', EntityType::class, [
                'class' => IoPortInterface::class,
                'choice_label' => 'name',
                'label' => 'Connector',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Type to select a connector ...',
            ])
            ->add('ioPortSignals', EntityType::class, [
                'class' => IoPortSignal::class,
                'multiple' => true,
                'label' => 'Signals',
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder'=> 'Type to select an io port signal ...',
            ])
            ->add('isInternal', CheckboxType::class, [
                'label'    => 'Internal port',
                'required' => false,
            ]);
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpansionCardIoPort::class,
        ]);
    }
}
