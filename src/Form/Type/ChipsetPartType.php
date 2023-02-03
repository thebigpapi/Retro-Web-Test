<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ChipsetPart;

class ChipsetPartType extends AbstractType
{
    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chipset_part', EntityType::class, [
                'class' => ChipsetPart::class,
                'choice_label' => 'getFullName',
                'multiple' => false,
                'expanded' => false,
                ])
            ->add('index',NumberType::class, [
                'required' => true,
            ]);
    }*/

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => ChipsetPart::class,
            'choice_label' => 'getFullName',
            'multiple' => false,
            'expanded' => false,
            'autocomplete' => true,
        ]);
    }

    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChipsetChipsetPart::class,
        ]);
    }*/
    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
