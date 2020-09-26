<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\CpuSpeed;

class ProcessorSpeedType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => CpuSpeed::class,
                
            'choice_label' => 'getValueWithUnit',
            'multiple' => false,
            'expanded' => false,
        ]);
    }

    public function getParent()
    {
        return EntityType::class;
    }
}