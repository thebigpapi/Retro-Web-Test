<?php

namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpansionCardImageFilterType extends AbstractType
{
    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Schema' => '1',
                'Photo front' => '2',
                'Photo back' => '3',
                'Photo misc' => '4',
                'Schema misc' => '5',
            ],
        ]);
    }

    /**
     * @return ?string
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}