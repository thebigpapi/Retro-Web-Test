<?php

namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoolFilterType extends AbstractType
{
    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Yes' => 'yes',
                'No' => 'no',
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