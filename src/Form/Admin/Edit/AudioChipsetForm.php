<?php

namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\AudioChipset;
use App\Entity\Manufacturer;
use App\Form\Type\LargeFileAudioChipsetType;

class AudioChipsetForm extends AbstractType
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
            ->add('drivers', CollectionType::class, [
                'entry_type' => LargeFileAudioChipsetType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AudioChipset::class,
            'chipsetManufacturers' => array(),
        ]);
    }
}
