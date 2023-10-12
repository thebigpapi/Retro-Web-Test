<?php

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\IoPort;

class IoPortSearchType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    private function getIoPortRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(IoPort::class);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count', TextType::class,[
                'label' => false,
            ])
            ->add('io_port', EntityType::class, [
                'class' => IoPort::class,
                'choice_label' => 'name',
                'choices' => $this->getIoPortRepository()->findByPopularity(),
                'label' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'placeholder' => 'Select type...',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
