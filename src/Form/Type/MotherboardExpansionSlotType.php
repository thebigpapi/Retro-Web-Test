<?php

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\MotherboardExpansionSlot;
use App\Entity\ExpansionSlot;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class MotherboardExpansionSlotType extends AbstractType
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
            ->add('count', NumberType::class,[
                'label' => false,
            ])
            ->add('expansion_slot', EntityType::class, [
                'class' => ExpansionSlot::class,
                'choice_label' => 'name',
                //'choices' => $this->getExpansionSlotRepository()->findByPopularity(),
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
        $resolver->setDefaults([
            'data_class' => MotherboardExpansionSlot::class,
        ]);
    }
}
