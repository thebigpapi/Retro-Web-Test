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
            ->add('chipsetManufacturer', ChoiceType::class, [
                'choice_label' => 'getShortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['chipsetManufacturers'],
                'placeholder' => 'Select a chipset manufacturer ...',
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
            /*->add('processorPlatformType', ChoiceType::class, [
                //'class' => ProcessorPlatformType::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['procPlatformTypes'],
		        'placeholder' => 'Select a processor platform ...',
            ])*/
            /*->add('motherboardExpansionSlots', CollectionType::class, [
                'entry_type' => SearchMotherboardExpansionSlotType::class,
                /*'allow_add' => true,
                'allow_delete' => true,*/
            /*    'required' => false,
            ])*/
            /*->add('motherboardIoPorts', CollectionType::class, [
                'entry_type' => SearchMotherboardIoPortType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
            ])*/
            /*->add('motherboardMaxRam', EntityType::class, [
                'class' => MaxRam::class,

                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])*/
            /*->add('searchFormFactor', CheckboxType::class, [
                'label'    => ' ',
                'required' => false,
            ])*/
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

        $formModifier = function (FormInterface $form, Manufacturer $chipsetManufacturer = null) {
            $chipsets = (null === $chipsetManufacturer) ? [] : $chipsetManufacturer->getChipsets()->toArray();
            $unidentified = null;

            foreach ($chipsets as $key => $val) {
                if ($val->getName() == "unidentified") {
                    $unidentified = $val;
                    unset($chipsets[$key]);
                }
            }

            usort(
                $chipsets,
                function (Chipset $a, Chipset $b) {
                    return strcmp($a->getFullNameParts(), $b->getFullNameParts());
                }
            );

            if ($unidentified) {
                array_unshift($chipsets, $unidentified);
            }
            $chipTag = (null === $chipsetManufacturer) ? "No chipset selected!" : "any " . $chipsetManufacturer->getShortNameIfExist() . " chipset";
            $form->add('chipset', ChoiceType::class, [
                'choice_label' => 'getFullNameParts',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $chipsets,
                'placeholder' => $chipTag,
            ]);
        };
        //dd($builder->get('chipsetManufacturer'));
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), null);
            }
        );

        $builder->get('chipsetManufacturer')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $chipsetManufacturer = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $chipsetManufacturer);
            }
        );

        $formSocket1Modifier = function (FormInterface $form, CpuSocket $socket = null) {
            $platforms = null === $socket ? $this->getProcessorPlatformTypeRepository()
                ->findAll() : $socket->getPlatforms()->toArray();
            usort($platforms, function ($a, $b) {return strnatcasecmp($a->getName(), $b->getName());});
            $form->add('platform1', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $platforms,
                'placeholder' => 'Select a processor platform ...',
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formSocket1Modifier) {
                $data = $event->getData();
                $formSocket1Modifier($event->getForm(), null);
            }
        );

        $builder->get('cpuSocket1')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formSocket1Modifier) {
                $cpuSocket1 = $event->getForm()->getData();
                $formSocket1Modifier($event->getForm()->getParent(), $cpuSocket1);
            }
        );

        $formSocket2Modifier = function (FormInterface $form, CpuSocket $socket = null) {
            $platforms = null === $socket ? $this->getProcessorPlatformTypeRepository()
                ->findAll() : $socket->getPlatforms()->toArray();
            usort($platforms, function ($a, $b) {return strnatcasecmp($a->getName(), $b->getName());});
            $form->add('platform2', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $platforms,
                'placeholder' => 'Select a processor platform ...',
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formSocket2Modifier) {
                $data = $event->getData();
                $formSocket2Modifier($event->getForm(), null);
            }
        );

        $builder->get('cpuSocket2')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formSocket2Modifier) {
                $cpuSocket2 = $event->getForm()->getData();
                $formSocket2Modifier($event->getForm()->getParent(), $cpuSocket2);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'moboManufacturers' => array(),
            'chipsetManufacturers' => array(),
            'bios' => array(),
            'formFactors' => array(),
            'procPlatformTypes' => array(),
            'cpuSockets' => array(),
        ]);
    }
}
