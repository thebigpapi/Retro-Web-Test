<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Processor;
use App\Entity\ProcessorPlatformType;
use App\Entity\Manufacturer;

class EditProcessor extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['processorManufacturers'],
            ])
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('processorPlatformType', EntityType::class, [
                'class' => ProcessorPlatformType::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Processor::class,
            'processorManufacturers' => array(),
        ]);
    }
}