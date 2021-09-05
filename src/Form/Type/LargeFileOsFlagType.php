<?php

namespace App\Form\Type;

use App\Entity\LargeFileOsFlag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\OsFlag;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class LargeFileOsFlagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unsure', CheckboxType::class)
            ->add('osFlag', EntityType::class, [
                'class' => OsFlag::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LargeFileOsFlag::class,
        ]);
    }
}
