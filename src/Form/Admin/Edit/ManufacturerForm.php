<?php

namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Manufacturer;
use App\Form\Type\ManufacturerBiosManufacturerCodeType;
use App\Form\Type\PciVendorIdType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ManufacturerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('fullName', TextType::class, [
                'required' => false,
            ])
            ->add('fccid', TextType::class, [
                'required' => false,
            ])
            ->add('pciVendorIds', CollectionType::class, [
                'entry_type' => PciVendorIdType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class)
            ->add('biosCodes', CollectionType::class, [
                'entry_type' => ManufacturerBiosManufacturerCodeType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Manufacturer::class,
        ]);
    }
}
