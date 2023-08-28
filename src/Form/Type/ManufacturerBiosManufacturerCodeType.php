<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Manufacturer;
use App\Entity\ManufacturerBiosManufacturerCode;

class ManufacturerBiosManufacturerCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('biosManufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                ])
            ->add('code', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ManufacturerBiosManufacturerCode::class,
        ]);
    }
}
