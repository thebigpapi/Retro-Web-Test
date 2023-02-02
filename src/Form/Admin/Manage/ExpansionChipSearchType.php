<?php

namespace App\Form\Admin\Manage;

use App\Entity\Manufacturer;
use App\Entity\ExpansionChipType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ExpansionChipSearchType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturer', ChoiceType::class, [
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $this->entityManager
                    ->getRepository(Manufacturer::class)
                    ->findAllExpansionChipManufacturer(),
                'placeholder' => 'Select a manufacturer ...'
            ])
            ->add('type', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $this->entityManager
                    ->getRepository(ExpansionChipType::class)
                    ->findByType(),
                'placeholder' => 'Select a type ...'
            ])
            ->add('search', SubmitType::class);
    }
}
