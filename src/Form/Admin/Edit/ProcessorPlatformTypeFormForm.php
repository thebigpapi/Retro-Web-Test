<?php
namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\ProcessorPlatformType;
use App\Form\Type\ProcessorPlatformTypeForm;
use App\Entity\Manufacturer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProcessorPlatformTypeFormForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('compatibleWith', CollectionType::class, [
                'entry_type' => ProcessorPlatformTypeForm::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProcessorPlatformType::class,
        ]);
    }
}