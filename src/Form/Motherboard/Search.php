<?php

namespace App\Form\Motherboard;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use App\Entity\CpuSocket;
use App\Entity\DramType;
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
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            /*->add('searchManufacturer', CheckboxType::class, [
                'label'    => ' ',
                'required' => false,
            ])*/
            ->add('manufacturer', ChoiceType::class, [
                //'class' => Manufacturer::class,

                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['moboManufacturers'],
                'placeholder' => 'Select a manufacturer ...'
            ])
            /*->add('searchChipset', CheckboxType::class, [
                'label'    => ' ',
                'required' => false,
            ])*/
            ->add('chipsetManufacturer', ChoiceType::class, [
                //'class' => Chipset::class,

                'choice_label' => 'getShortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['chipsetManufacturers'],
                'placeholder' => 'Select a chipset manufacturer ...',
            ])
            /*->add('searchProcessorPlatformType', CheckboxType::class, [
                'label'    => ' ',
                'required' => false,
            ])*/
            ->add('cpuSocket1', ChoiceType::class, [
                //'class' => ProcessorPlatformType::class,
                'choice_label' => 'getNameAndType',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['cpuSockets'],
                'placeholder' => 'Select a socket ...',
            ])
            ->add('cpuSocket2', ChoiceType::class, [
                //'class' => ProcessorPlatformType::class,
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
            ->add('dramType', EntityType::class, [
                'class' => DramType::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
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
                //'class' => FormFactor::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['formFactors'],
                'placeholder' => 'Select a form factor ...',
            ])
            /*->add('motherboardBios', EntityType::class, [
                'class' => Manufacturer::class,

                'choice_label' => 'shortNameIfExist',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'choices' => $options['bios'],
            ])*/
            ->add('search', SubmitType::class)
            ->add('searchWithImages', SubmitType::class)
            ->add('searchChipsetManufacturer', SubmitType::class, ['label' => 'List chipsets'])
            ->add('searchSocket1', SubmitType::class, ['label' => 'List platforms'])
            ->add('searchSocket2', SubmitType::class, ['label' => 'List platforms'])
        ;

        $formModifier = function (FormInterface $form, Manufacturer $chipsetManufacturer = null) {
            $chipsets = null === $chipsetManufacturer ? [] : $chipsetManufacturer->getChipsets()->toArray();

            /*$formOptions = [
                'class' => Chipset::class,
                'choice_label' => 'getMainChipWithManufacturer',
                'query_builder' => function (ChipsetRepository $chipsetRepository) use ($manufacturer) {
                    return $chipsetRepository->findByManufacturer($manufacturer);
                    // call a method on your repository that returns the query builder
                    // return $userRepository->createFriendsQueryBuilder($user);
                },
            ];*/




            /*if($chipsetManufacturer)
                $formOptions = array(new Chipset());
            else
                $formOptions = array();**/
            /*if($chipsets)
                dd($chipsets);*/

            /*if($chipsetManufacturer)
            {*/
                usort($chipsets, function ($a, $b) {
                    if ($a->getFullReference() == $b->getFullReference()) {
                        return 0;
                    }
                    if ($a->getFullReference() == " Unidentified ") {
                        return -1;
                    }
                    return ($a->getFullReference() < $b->getFullReference()) ? -1 : 1;
                });
                //if ($chipsetManufacturer) dd($chipsets[94]->getFullReference()==" Unidentified ");
                $form->add('chipset', ChoiceType::class, [
                    //'class' => Chipset::class,
                    'choice_label' => 'getFullReference',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'choices' => $chipsets,
                    'placeholder' => '*',
                ]);
            //}
            /*if($chipsetManufacturer)
                dd($form->getData());*/
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                //dd($data);

                $formModifier($event->getForm(), null);
            }
        );

        /*$builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();

                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                dd($form);
            }
        );*/

        $builder->get('chipsetManufacturer')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $chipsetManufacturer = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $chipsetManufacturer);
            }
        );

        /*$builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $test = $event->getData();
            $form = $event->getForm();

            if ($form->get('searchChipsetManufacturer')->isClicked())
            {
                $formOptions = [
                    'class' => Chipset::class,
                    'choice_label' => 'getMainChipWithManufacturer',
                    'query_builder' => function (ChipsetRepository $userRepository) {
                        return $userRepository->findAllMotherboardChipset();
                        // call a method on your repository that returns the query builder
                        // return $userRepository->createFriendsQueryBuilder($user);
                    },
                ];

                $form->add('chipset', ChoiceType::class, [
                    //'class' => Chipset::class,
                    'choice_label' => 'getMainChipWithManufacturer',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'choices' => $formOptions,
                    'placeholder' => '*',
                ]);
            }
                //dd($test);
        });*/

        $formSocket1Modifier = function (FormInterface $form, CpuSocket $socket = null) {
            $platforms = null === $socket ? $this->getProcessorPlatformTypeRepository()
            ->findAll() : $socket->getPlatforms()->toArray();
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
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                //dd($data);

                $formSocket1Modifier($event->getForm(), null);
            }
        );

        $builder->get('cpuSocket1')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formSocket1Modifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $cpuSocket1 = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formSocket1Modifier($event->getForm()->getParent(), $cpuSocket1);
            }
        );

        $formSocket2Modifier = function (FormInterface $form, CpuSocket $socket = null) {
            $platforms = null === $socket ? $this->getProcessorPlatformTypeRepository()
            ->findAll() : $socket->getPlatforms()->toArray();
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
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                //dd($data);

                $formSocket2Modifier($event->getForm(), null);
            }
        );

        $builder->get('cpuSocket2')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formSocket2Modifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $cpuSocket2 = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
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
