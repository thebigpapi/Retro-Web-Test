<?php

namespace App\Form\Motherboard;

use App\Entity\Chipset;
use App\Form\Type\DramTypeType;
use App\Form\Type\ExpansionSlotSearchType;
use App\Form\Type\IoPortSearchType;
use App\Form\Type\ExpansionChipType;
use App\Form\Type\ItemsPerPageType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Entity\Manufacturer;
use App\Entity\CpuSocket;
use App\Entity\FormFactor;
use App\Entity\ProcessorPlatformType;
use App\Repository\ManufacturerRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;

class Search extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getProcessorPlatformTypeRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(ProcessorPlatformType::class);
    }
    private function getManufacturerRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Manufacturer::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // sorting some fields before adding them to the form
        usort($options['cpuSockets'], function (CpuSocket $a, CpuSocket  $b) {
            if (!$a->getName() && !$b->getName()) {
                return strnatcasecmp($a->getType() ?? '', $b->getType() ?? '');
            } else {
                return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
            }
        });

        usort($options['formFactors'], function (FormFactor $a, FormFactor $b) {
            return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
        });

        //now the form is being built
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('manufacturer', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['moboManufacturers'],
                'placeholder' => 'Type to select a manufacturer ...'
            ])
            ->add('expansionChips', CollectionType::class, [
                'entry_type' => ExpansionChipType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('dramTypes', CollectionType::class, [
                'entry_type' => DramTypeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('cpuSocket1', ChoiceType::class, [
                'choice_label' => 'getNameAndType',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'autocomplete' => true,
                'choices' => $options['cpuSockets'],
                'placeholder' => 'Type to select a socket ...',
            ])
            ->add('cpuSocket2', ChoiceType::class, [
                'choice_label' => 'getNameAndType',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'autocomplete' => true,
                'choices' => $options['cpuSockets'],
                'placeholder' => 'Type to select a socket ...',
            ])
            ->add('formFactor', ChoiceType::class, [
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'autocomplete' => true,
                'choices' => $options['formFactors'],
                'placeholder' => 'Type to select a form factor ...',
            ])
            ->add('motherboardExpansionSlots', CollectionType::class, [
                'entry_type' => ExpansionSlotSearchType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('motherboardIoPorts', CollectionType::class, [
                'entry_type' => IoPortSearchType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('searchWithImages', CheckboxType::class, [
                'data' => true,
                'label' => false,
                'attr' => array('checked' => 'checked'),
            ])
            ->add('itemsPerPage', EnumType::class, [
                'class' => ItemsPerPageType::class,
                'empty_data' => ItemsPerPageType::Items100,
                'choice_label' => fn ($choice) => strval($choice->value),
            ])
            ->add('page', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'value' => 1,
                ]
            ]);

        $formModifier = function (FormInterface $form, Manufacturer $chipsetManufacturer = null) {
            /**
             * @var Chipset[]
             */
            $chipsets = [];
            $chipsetManuf = $this->getManufacturerRepository()->findAllChipsetManufacturer();
            usort(
                $chipsetManuf,
                function (Manufacturer $a, Manufacturer $b) {
                    return strcmp($a->getName(), $b->getName());
                }
            );
            foreach($chipsetManuf as $man){
                $cm = $man->getChipsets()->toArray() ?? [];
                $any = new Chipset;
                $any->setName(" chipset of any kind");
                $any->setManufacturer($man);
                array_unshift($cm, $any);
                $chipsets = array_merge($chipsets, $cm);
            }
            usort(
                $chipsets,
                function (Chipset $a, Chipset $b) {
                    return strcmp($a->getNameCached(), $b->getNameCached());
                }
            );
            $form->add('chipset', ChoiceType::class, [
                'choice_label' => 'getNameCachedSearch',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $chipsets,
                'placeholder' => "Type to select a chipset ...",
            ]);
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), null);
            }
        );

        $formSocket1Modifier = function (FormInterface $form, CpuSocket $socket = null) {
            $platforms = null === $socket ? $this->getProcessorPlatformTypeRepository()
                ->findAll() : $socket->getPlatforms()->toArray();
            usort($platforms, function (ProcessorPlatformType $a, ProcessorPlatformType $b) {
                return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
            });
            $form->add('platform1', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'autocomplete' => true,
                'choices' => $platforms,
                'placeholder' => 'Type to select a processor family ...',
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
            usort(
                $platforms,
                function (ProcessorPlatformType $a, ProcessorPlatformType $b) {
                    return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
                }
            );
            $form->add('platform2', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'autocomplete' => true,
                'choices' => $platforms,
                'placeholder' => 'Type to select a processor family ...',
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
