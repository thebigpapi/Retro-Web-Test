<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\IoPort2;
use App\Entity\ExpansionCardIoPort;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
            ->add('ioPort', EntityType::class, [
                'class' => IoPort2::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Type to select a connector ...',
            ])
            ->add('ioPortTypes', CollectionType::class, [
                'entry_type' => ExpansionCardIoPortIoPortTypeType::class,
                'allow_add' => true,
                'allow_delete' => true,
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
