<?php

namespace App\Form\Type;

use App\Entity\LargeFileMediaTypeFlag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\MediaTypeFlag;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LargeFileMediaTypeFlagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', NumberType::class)
            ->add('mediaTypeFlag', EntityType::class, [
                'class' => MediaTypeFlag::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LargeFileMediaTypeFlag::class,
        ]);
    }
}
