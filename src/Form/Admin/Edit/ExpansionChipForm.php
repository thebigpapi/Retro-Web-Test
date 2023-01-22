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
use App\Form\Type\ChipDocumentationType;
use App\Form\Type\ChipType;

class ExpansionChipForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chip', ChipType::class, [
                'data_class' =>ExpansionChip::class,
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
            ->add('documentations', CollectionType::class, [
                'entry_type' => ChipDocumentationType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpansionChip::class,
            'chipsetManufacturers' => array(),
        ]);
    }
}
