<?php

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ExpansionChip;

class ExpansionChipType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    private function getExpChipRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(ExpansionChip::class);
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => ExpansionChip::class,
            'choice_label' => 'getNameWithManufacturer',
            'choices' => $this->getExpChipRepository()->findByPopularity(),
            'multiple' => false,
            'expanded' => false,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            'placeholder'=> 'Type to select a chip ...',
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
