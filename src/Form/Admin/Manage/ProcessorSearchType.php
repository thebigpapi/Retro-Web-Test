<?php

namespace App\Form\Admin\Manage;

use App\Entity\Manufacturer;
use App\Entity\ProcessorPlatformType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ProcessorSearchType extends AbstractType
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
                ->findAllProcessorManufacturer(),
                'placeholder' => 'Select a manufacturer ...'
            ])
            ->add('platform', EntityType::class, [
                'class' => ProcessorPlatformType::class,
                'choice_label' => 'getName',
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'placeholder' => 'Select a platform ...'
            ])
            ->add('search', SubmitType::class);
        ;
    }
}
