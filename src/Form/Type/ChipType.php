<?php

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Chip;

class ChipType extends AbstractType
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Chip::class,
            'choice_label' => 'getFullNameAlias',
            'choices' =>  $this->entityManager->getRepository(Chip::class)->findAllWithAliases(),
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
