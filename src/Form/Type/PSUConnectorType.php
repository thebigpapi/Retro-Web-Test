<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\PSUConnector;

class PSUConnectorType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => PSUConnector::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
