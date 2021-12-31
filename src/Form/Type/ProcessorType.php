<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Processor;

class ProcessorType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Processor::class,

            'choice_label' => 'getNameWithSpecs',
            'multiple' => false,
            'expanded' => false,
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
