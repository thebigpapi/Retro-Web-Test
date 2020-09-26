<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Coprocessor;

class CoprocessorType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Coprocessor::class,
                
            'choice_label' => 'getNameWithManufacturer',
            'multiple' => false,
            'expanded' => false,
        ]);
    }

    public function getParent()
    {
        return EntityType::class;
    }
}