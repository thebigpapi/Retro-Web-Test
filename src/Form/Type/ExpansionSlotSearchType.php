<?php

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\ExpansionSlot;

class ExpansionSlotSearchType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', TextType::class,[
                'label' => false,
            ])
            ->add('expansion_slot', EntityType::class, [
                'class' => ExpansionSlot::class,
                'choice_label' => 'name',
                'choices' => $this->entityManager->getRepository(ExpansionSlot::class)->findByPopularity(),
                'label' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Type to select a type...',
            ])
;
    }
}
