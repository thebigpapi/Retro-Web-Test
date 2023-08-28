<?php

namespace App\Form\Admin\Manage;

use App\Entity\Manufacturer;
use App\Entity\FormFactor;
use App\Entity\Chipset;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class MotherboardSearchType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * @var Chipset[]
         */
        $chipsets = $this->entityManager->getRepository(Chipset::class)->findAll();
        usort(
            $chipsets,
            function (Chipset $a, Chipset $b) {
                if ($a->getManufacturer()->getName() == $b->getManufacturer()->getName()) {
                    if ($a->getFullReference() == $b->getFullReference()) {
                        return 0;
                    }
                    if ($a->getFullReference() == " Unidentified ") {
                        return -1;
                    }
                    return ($a->getFullReference() < $b->getFullReference()) ? -1 : 1;
                }
                return ($a->getManufacturer()->getName() < $b->getManufacturer()->getName()) ? -1 : 1;
            }
        );
        $builder
            ->add('name', TextType::class, ['required' => false,])
            ->add('manufacturer', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $this->entityManager
                    ->getRepository(Manufacturer::class)
                    ->findAll(),
                'placeholder' => 'Select a manufacturer ...'
            ])
            ->add('formFactor', EntityType::class, [
                'class' => FormFactor::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('chipset', EntityType::class, [
                'class' => Chipset::class,

                'choice_label' => 'getFullReference',
                'multiple' => false,
                'expanded' => false,
                'choices' => $chipsets,
                'required' => false,
            ])
            ->add('search', SubmitType::class);
    }
}
