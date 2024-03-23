<?php

namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchemaPhotoImageFilterType extends AbstractType
{
    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Any' => 'any',
                'Contains schema' => 'schema',
                'Contains photo' => 'photo',
                'Schema only' => 'schemaonly',
                'Photo only' => 'photoonly',
                'None' => 'none',
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