<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\MotherboardExpansionSlot;
use App\Entity\ExpansionSlot;

class SearchMotherboardExpansionSlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expansion_slot', EntityType::class, [
                'class' => ExpansionSlot::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                ])
            ->add('count', NumberType::class);
    }
}
