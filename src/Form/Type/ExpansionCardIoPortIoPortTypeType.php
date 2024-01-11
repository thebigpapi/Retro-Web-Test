<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\IoPortType;
use App\Repository\IoPortTypeRepository;

class ExpansionCardIoPortIoPortTypeType extends AbstractType
{

    public function __construct(private IoPortTypeRepository $ioPortTypeRepository)
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
            'class' => IoPortType::class,
            'choice_label' => 'name',
            'choices' => $this->ioPortTypeRepository->findAll(),
            'multiple' => false,
            'expanded' => false,
            'attr' => ['data-ea-widget' => 'ea-autocomplete'],
            'placeholder'=> 'Type to select an io port type ...',
        ]);
    }


}
