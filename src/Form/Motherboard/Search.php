<?php

namespace App\Form\Motherboard;

use App\Entity\Chipset;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use App\Entity\CpuSocket;
use App\Entity\ProcessorPlatformType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use App\Repository\ProcessorPlatformTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class Search extends AbstractType
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getProcessorPlatformTypeRepository(): ProcessorPlatformTypeRepository
    {
        return $this->entityManager->getRepository(ProcessorPlatformType::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // sorting some fields before adding them to the form
        usort($options['cpuSockets'], function ($a, $b) {
            if(!$a->getName() && !$b->getName())return strnatcasecmp($a->getType(), $b->getType());
            else return strnatcasecmp($a->getName(), $b->getName());
        });

        usort($options['formFactors'], function ($a, $b) {
            return strnatcasecmp($a->getName(), $b->getName());
        });

        usort($options['chipsets'], function ($a, $b) {
            return strnatcasecmp($a->getFullName(), $b->getFullName());
        });

        $platforms =  $this->getProcessorPlatformTypeRepository()->findAll();
        usort($platforms, function ($a, $b) {
            return strnatcasecmp($a->getName(), $b->getName());
        });
        

        //now the form is being built
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('manufacturer', ChoiceType::class, [
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['moboManufacturers'],
                'placeholder' => 'Select a manufacturer ...'
            ])
            ->add('chipset', ChoiceType::class, [
                'choice_label' => 'getFullNameParts',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['chipsets'],
                'placeholder' => 'Select a chipset ...',
            ])
            ->add('cpuSocket1', ChoiceType::class, [
                'choice_label' => 'getNameAndType',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['cpuSockets'],
                'placeholder' => 'Select a socket ...',
            ])
            ->add('cpuSocket2', ChoiceType::class, [
                'choice_label' => 'getNameAndType',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['cpuSockets'],
                'placeholder' => 'Select a socket ...',
            ])
            ->add('platform1', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' =>  $platforms,
                'placeholder' => 'Select a processor platform ...',
            ])
            ->add('platform2', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $platforms,
                'placeholder' => 'Select a processor platform ...',
            ])
            ->add('formFactor', ChoiceType::class, [
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['formFactors'],
                'placeholder' => 'Select a form factor ...',
            ])
            ->add('search', SubmitType::class)
            ->add('searchWithImages', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'moboManufacturers' => array(),
            'chipsets' => array(),
            'bios' => array(),
            'formFactors' => array(),
            'procPlatformTypes' => array(),
            'cpuSockets' => array(),
        ]);
    }
}
