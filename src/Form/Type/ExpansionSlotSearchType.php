<?php

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\MotherboardExpansionSlot;
use App\Entity\ExpansionSlot;

class ExpansionSlotSearchType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    private function getExpansionSlotRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(ExpansionSlot::class);
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
                'choices' => $this->getExpansionSlotRepository()->findByPopularity(),
                'label' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Select type...',
            ])
;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
