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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'label' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Type to select a connector ...',
            ])
            ->add('ioPortSignals', CollectionType::class, [
                'entry_type' => ExpansionCardIoPortSignalType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            /*->add('ioPortSignals', EntityType::class, [
                'class' => IoPortSignal::class,
            //'choice_label' => 'name',
            //'choices' => $this->ioPortSignalRepository->findAll(),
            'multiple' => false,
            'expanded' => false,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            'placeholder'=> 'Type to select an io port type ...',
            ])*/
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
