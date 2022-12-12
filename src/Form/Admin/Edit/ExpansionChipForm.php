<?php

namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\ExpansionChip;
use App\Entity\Manufacturer;
use App\Entity\ExpansionChipType;
use App\Form\Type\LargeFileExpansionChipType;

class ExpansionChipForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['chipsetManufacturers'],
            ])
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('chipName', TextType::class, [
                'required' => false,
            ])
            ->add('type', EntityType::class, [
                'class' => ExpansionChipType::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('drivers', CollectionType::class, [
                'entry_type' => LargeFileExpansionChipType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpansionChip::class,
            'chipsetManufacturers' => array(),
        ]);
    }
}
