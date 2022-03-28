<?php

namespace App\Form\Admin\Manage;

use App\Entity\Manufacturer;
use App\Entity\FormFactor;
use App\Entity\Chipset;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class MotherboardSearchType extends AbstractType
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['required' => false,])
            ->add('manufacturer', ChoiceType::class, [
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $this->entityManager
                ->getRepository(Manufacturer::class)
                ->findAll(),
                'placeholder' => 'Select a manufacturer ...'
            ])
            ->add('formFactor', EntityType::class, [
                'class' => FormFactor::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('chipset', EntityType::class, [
                'class' => Chipset::class,

                'choice_label' => 'getMainChipWithManufacturer',
                'multiple' => false,
                'expanded' => false,
                'choices' => $this->entityManager
                ->getRepository(Chipset::class)
                ->findAll(),
                'required' => false,
            ])
            ->add('search', SubmitType::class);
        ;
    }
}
