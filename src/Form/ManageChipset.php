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
use App\Entity\Chipset;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ManageChipset extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('chipsets', EntityType::class, [
            'class' => Chipset::class,
            'choice_label' => 'getMainChipWithManufacturer',
            'multiple' => false,
            'expanded' => false,
            'choices' => $options['chipsets'],
        ])
        ->add('edit', SubmitType::class)
        ->add('add', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'chipsets' => array(),
        ]);
    }
}