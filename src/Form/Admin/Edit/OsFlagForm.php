<?php

namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Manufacturer;
use App\Entity\OsFlag;

class OsFlagForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('version', TextType::class)
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OsFlag::class,
        ]);
    }
}
