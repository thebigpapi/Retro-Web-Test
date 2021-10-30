<?php

namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\InstructionSet;
use App\Form\Type\InstructionSetType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class InstructionSetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('compatibleWith', CollectionType::class, [
                'entry_type' => InstructionSetType::class,
                'allow_add' => true,
                'allow_delete' => true,
                ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InstructionSet::class,
        ]);
    }
}
