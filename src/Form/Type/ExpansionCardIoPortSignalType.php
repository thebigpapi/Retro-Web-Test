<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\IoPortSignal;
use App\Repository\IoPortSignalRepository;

class ExpansionCardIoPortSignalType extends AbstractType
{

    public function __construct(private IoPortSignalRepository $ioPortSignalRepository)
    {}

    public function getParent(): ?string
    {
        return EntityType::class;
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => IoPortSignal::class,
            'choice_label' => 'name',
            'choices' => $this->ioPortSignalRepository->findAll(),
            'multiple' => false,
            'expanded' => false,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            'placeholder'=> 'Type to select an io port type ...',
        ]);
    }


}
