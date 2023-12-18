<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\MemoryConnector;
use App\Entity\MotherboardMemoryConnector;

class MotherboardMemoryConnectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', NumberType::class,[
                'label' => false,
            ])
            ->add('memoryConnector', EntityType::class, [
                'class' => MemoryConnector::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Type to select a type...',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotherboardMemoryConnector::class,
        ]);
    }
}
