<?php

namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StorageDeviceImageFilterType extends AbstractType
{
    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Schema' => '1',
                'Top photo' => '2',
                'Front photo' => '3',
                'Back photo' => '4',
                'Bottom photo' => '5',
                'Misc' => '6',
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