<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ExpansionSlotSignal;

class ExpansionSlotSignalType extends AbstractType
{
    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => ExpansionSlotSignal::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            'placeholder'=> 'Type to select a signal ...',
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
