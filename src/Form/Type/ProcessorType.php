<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use App\Entity\Processor;

class ProcessorType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Processor::class,
                
            'choice_label' => 'getNameWithPlatform',
            'multiple' => false,
            'expanded' => false,
        ]);
    }

    public function getParent()
    {
        return EntityType::class;
    }

}