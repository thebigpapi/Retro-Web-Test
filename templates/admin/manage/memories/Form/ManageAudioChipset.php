<?php
namespace App\Form;

use App\Entity\Motherboard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\AudioChipset;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ManageAudioChipset extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('audioChipsets', EntityType::class, [
            'class' => AudioChipset::class,
            'choice_label' => 'getNameWithManufacturer',
            'multiple' => false,
            'expanded' => false,
            'choices' => $options['audioChipsets'],
        ])
        ->add('edit', SubmitType::class)
        ->add('add', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'audioChipsets' => array(),
        ]);
    }
}