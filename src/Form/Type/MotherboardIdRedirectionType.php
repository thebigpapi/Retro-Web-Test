<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\MotherboardIdRedirection;

class MotherboardIdRedirectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('source', NumberType::class, [
                'required' => true,
            ])
            ->add('sourceType', ChoiceType::class, [
                'choices'  => [
                    'UH19' => 'uh19',
                    'TH99' => 'th99',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotherboardIdRedirection::class,
        ]);
    }
}
