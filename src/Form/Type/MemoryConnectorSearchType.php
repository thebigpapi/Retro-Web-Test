<?php

namespace App\Form\Motherboard;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\MemoryConnector;

class MemoryConnectorSearchType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', TextType::class,[
                'label' => false,
            ])
            ->add('io_port', EntityType::class, [
                'class' => MemoryConnector::class,
                'choice_label' => 'name',
                'choices' => $this->entityManager->getRepository(MemoryConnector::class)->findByPopularity(),
                'label' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Type to select a type...',
            ]);
    }
}
