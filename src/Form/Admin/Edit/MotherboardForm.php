<?php

namespace App\Form\Admin\Edit;

use App\Entity\Motherboard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Manufacturer;
use App\Entity\Chipset;
use App\Entity\Processor;
use App\Entity\Coprocessor;
use App\Entity\DramType;
use App\Entity\FormFactor;
use App\Entity\ProcessorPlatformType;
use App\Entity\VideoChipset;
use App\Entity\AudioChipset;
use App\Entity\CpuSocket;
use App\Entity\CpuSpeed;
use App\Entity\MaxRam;
use App\Entity\PSUConnector;
use App\Form\Type\ProcessorType;
use App\Form\Type\CoprocessorType;
use App\Form\Type\ProcessorSpeedType;
use App\Form\Type\MotherboardExpansionSlotType;
use App\Form\Type\MotherboardAliasType;
use App\Form\Type\MotherboardIoPortType;
use App\Form\Type\MotherboardMaxRamType;
use App\Form\Type\CacheSizeType;
use App\Form\Type\DramTypeType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ManualType;
use App\Form\Type\MotherboardBiosType;
use App\Form\Type\MotherboardImageTypeForm;
use App\Form\Type\KnownIssueType;
use App\Form\Type\LargeFileMotherboardType;
use App\Form\Type\MotherboardIdRedirectionType;
use App\Form\Type\ProcessorPlatformTypeForm;
use App\Form\Type\PSUConnectorType;
use App\Repository\CpuSocketRepository;
use App\Repository\CpuSpeedRepository;
use App\Repository\ProcessorPlatformTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Contracts\Cache\CacheInterface;

class MotherboardForm extends AbstractType
{
    public function __construct(EntityManagerInterface $entityManager, CacheInterface $cache)
    {
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    private function getProcessorPlatformTypeRepository(): ProcessorPlatformTypeRepository
    {
        return $this->entityManager->getRepository(ProcessorPlatformType::class);
    }

    private function getCpuSocketsRepository(): CpuSocketRepository
    {
        return $this->entityManager->getRepository(CpuSocket::class);
    }

    private function getCpuSpeedRepository(): CpuSpeedRepository
    {
        return $this->entityManager->getRepository(CpuSpeed::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$sockets = $options['sockets'] ?? null;
        $platforms = null;
        if($sockets) {
            if($sockets->isEmpty()) {
                $platforms = $this->getProcessorPlatformTypeRepository()
                ->findAll();
            }
            else {
                $platforms = array();
                foreach ($sockets as $socket) {
                    $platforms = array_merge($platforms,$socket->getPlatforms()->toArray());
                }
            }
        }*/
        $builder
            ->add('name', TextType::class)
            ->add('dimensions', TextType::class, [
                'required' => false,
            ])
            ->add('motherboardAliases', CollectionType::class, [
                'entry_type' => MotherboardAliasType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ])
            ->add('chipset', EntityType::class, [
                'class' => Chipset::class,
                'choice_label' => 'getFullNameParts',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['chipsets'],
                'required' => false,
            ])
            ->add('cpuSockets', CollectionType::class, [
                'entry_type' => CpuSocketType::class,

                'allow_add' => true,
                'allow_delete' => true,
                'entry_options'  => [
                    'choices' => $options['sockets'],
                ]
            ])
            ->add('slug', TextType::class)
            /*->add('processorPlatformType', EntityType::class, [
                'class' => ProcessorPlatformType::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['procPlatformTypes'],
            ])*/
            /*->add('coprocessors', CollectionType::class, [
                'entry_type' => CoprocessorType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])*/
            ->add('cpuSpeed', CollectionType::class, [
                'entry_type' => ProcessorSpeedType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('motherboardExpansionSlots', CollectionType::class, [
                'entry_type' => MotherboardExpansionSlotType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('motherboardIoPorts', CollectionType::class, [
                'entry_type' => MotherboardIoPortType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('dramType', CollectionType::class, [
                'entry_type' => DramTypeType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('motherboardMaxRams', CollectionType::class, [
                'entry_type' => MotherboardMaxRamType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('cacheSize', CollectionType::class, [
                'entry_type' => CacheSizeType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('formFactor', EntityType::class, [
                'class' => FormFactor::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('manuals', CollectionType::class, [
                'entry_type' => ManualType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('motherboardBios', CollectionType::class, [
                'entry_type' => MotherboardBiosType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => MotherboardImageTypeForm::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('knownIssues', CollectionType::class, [
                'entry_type' => KnownIssueType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('videoChipset', EntityType::class, [
                'class' => VideoChipset::class,
                'required' => false,
                'choice_label' => 'getNameWithManufacturer',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('maxVideoRam', EntityType::class, [
                'class' => MaxRam::class,
                'required' => false,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('audioChipset', EntityType::class, [
                'class' => AudioChipset::class,
                'required' => false,
                'choice_label' => 'getNameWithManufacturer',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('drivers', CollectionType::class, [
                'entry_type' => LargeFileMotherboardType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('note', TextareaType::class, [
                'required' => false,
            ])
            ->add('maxCpu', NumberType::class, [
                'required' => false,
            ])
            ->add('redirections', CollectionType::class, [
                'entry_type' => MotherboardIdRedirectionType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            /*->add('processorPlatformTypes', CollectionType::class, [
                'entry_type' => ProcessorPlatformTypeForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options'  => [
                    'choices' => $this->getProcessorPlatformTypeRepository()
                    ->findAll(),
                ],
            ])
            ->add('processors', CollectionType::class, [
                'entry_type' => ProcessorType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])*/
            ->add('psuConnectors', CollectionType::class, [
                'entry_type' => PSUConnectorType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class)
            ->add('updateProcessors', SubmitType::class, ['label' => 'Update processors']);

        $formSocketModifier = function (FormInterface $form, Collection $cpuSockets = null) {
            if ($cpuSockets->isEmpty()) {
                //dd("test");
                $platforms = $this->getProcessorPlatformTypeRepository()
                    ->findAll();
            } else {
                $platforms = array();
                if ($cpuSockets[0] instanceof CpuSocket) {
                    foreach ($cpuSockets as $socket) {
                        $platforms = array_merge($platforms, $socket->getPlatforms()->toArray());
                    }
                } else {
                    foreach ($cpuSockets as $socketId) {
                        $socket = $this->getCpuSocketsRepository()->find($socketId);
                        $platforms = array_merge($platforms, $socket->getPlatforms()->toArray());
                    }
                }
            }

            $form->add('processorPlatformTypes', CollectionType::class, [
                'entry_type' => ProcessorPlatformTypeForm::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options'  => [
                    'choices' => $platforms,
                ],
            ]);
        };


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formSocketModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formSocketModifier($event->getForm(), $data->getCpuSockets());
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formSocketModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $cpuSocketsIds = (array_key_exists(
                    "cpuSockets",
                    $event->getData()
                )) ? $event->getData()["cpuSockets"] : [];
                $formSocketModifier($event->getForm(), new ArrayCollection($cpuSocketsIds));
                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
            }
        );

        $formPlatformModifier = function (
            FormInterface $form,
            Collection $processorPlatformTypes,
            Collection $fsbs,
            Collection $sockets
        ) {
            $processorsWithPlatform = array();
            $coprocessorsWithPlatform = array();
            if (!$processorPlatformTypes->isEmpty()) {
                if (
                    is_object($processorPlatformTypes[0])
                    &&
                    $this->entityManager->getMetadataFactory()->getMetadataFor(
                        get_class($processorPlatformTypes[0])
                    )->getName()
                    ==
                    "App\Entity\ProcessorPlatformType"
                ) {
                    foreach ($processorPlatformTypes as $platform) {
                        $processorsWithPlatform = array_merge(
                            $processorsWithPlatform,
                            $platform->getCompatibleProcessors()->toArray()
                        );
                        $coprocessorsWithPlatform = array_merge(
                            $coprocessorsWithPlatform,
                            $platform->getCoprocessors()->toArray()
                        );
                    }
                } else {
                    foreach ($processorPlatformTypes as $platformId) {
                        $platform = $this->getProcessorPlatformTypeRepository()->find($platformId);
                        $processorsWithPlatform = array_merge(
                            $processorsWithPlatform,
                            $platform->getCompatibleProcessors()->toArray()
                        );
                        $coprocessorsWithPlatform = array_merge(
                            $coprocessorsWithPlatform,
                            $platform->getCoprocessors()->toArray()
                        );
                    }
                }
            }
            $processorsWithFsb = array();
            $coprocessorsWithFsb = array();
            if (!$fsbs->isEmpty()) {
                if (
                    is_object($fsbs[0])
                    &&
                    $this->entityManager->getMetadataFactory()->getMetadataFor(get_class($fsbs[0]))->getName()
                    ==
                    "App\Entity\CpuSpeed"
                ) {
                    foreach ($fsbs as $fsb) {
                        foreach ($processorsWithPlatform as $processor) {
                            if (
                                $processor->getFsb()->getValue() >= $fsb->getValue() - 1.0
                                &&
                                $processor->getFsb()->getValue() <= $fsb->getValue() + 1.0
                            ) {
                                $processorsWithFsb[] = $processor;
                            }
                        }
                        foreach ($coprocessorsWithPlatform as $coprocessor) {
                            if (
                                $coprocessor->getFsb()->getValue() >= $fsb->getValue() - 1.0
                                &&
                                $coprocessor->getFsb()->getValue() <= $fsb->getValue() + 1.0
                            ) {
                                $coprocessorsWithFsb[] = $coprocessor;
                            }
                        }
                    }
                } else {
                    foreach ($fsbs as $fsbId) {
                        $fsb = $this->getCpuSpeedRepository()->find($fsbId);
                        foreach ($processorsWithPlatform as $processor) {
                            if (
                                $processor->getFsb()->getValue() >= $fsb->getValue() - 1.0
                                &&
                                $processor->getFsb()->getValue() <= $fsb->getValue() + 1.0
                            ) {
                                $processorsWithFsb[] = $processor;
                            }
                        }
                        foreach ($coprocessorsWithPlatform as $coprocessor) {
                            if (
                                $coprocessor->getFsb()->getValue() >= $fsb->getValue() - 1.0
                                &&
                                $coprocessor->getFsb()->getValue() <= $fsb->getValue() + 1.0
                            ) {
                                $coprocessorsWithFsb[] = $coprocessor;
                            }
                        }
                    }
                }
            }
            $processorsWithSocket = array();
            $coprocessorsWithSocket = array();
            if (!$sockets->isEmpty()) {
                if (
                    is_object($sockets[0])
                    &&
                    $this->entityManager->getMetadataFactory()->getMetadataFor(get_class($sockets[0]))->getName()
                    ==
                    "App\Entity\CpuSocket"
                ) {
                    foreach ($sockets as $socket) {
                        foreach ($processorsWithFsb as $processor) {
                            if ($processor->getSockets()->contains($socket)) {
                                $processorsWithSocket[] = $processor;
                            }
                        }
                        foreach ($coprocessorsWithFsb as $coprocessor) {
                            if ($coprocessor->getSockets()->contains($socket)) {
                                $coprocessorsWithSocket[] = $coprocessor;
                            }
                        }
                    }
                } else {
                    foreach ($sockets as $socketId) {
                        $socket = $this->getCpuSocketsRepository()->find($socketId);
                        foreach ($processorsWithFsb as $processor) {
                            if ($processor->getSockets()->contains($socket)) {
                                $processorsWithSocket[] = $processor;
                            }
                        }
                        foreach ($coprocessorsWithFsb as $coprocessor) {
                            if ($coprocessor->getSockets()->contains($socket)) {
                                $coprocessorsWithSocket[] = $coprocessor;
                            }
                        }
                    }
                }
            } else {
                $processorsWithSocket = $processorsWithFsb;
                $coprocessorsWithSocket = $coprocessorsWithFsb;
            }
            $processorsWithSocket = Processor::sort(new ArrayCollection($processorsWithSocket));
            $coprocessorsWithSocket = Coprocessor::sort(new ArrayCollection($coprocessorsWithSocket));

            $form->add('processors', CollectionType::class, [
                'entry_type' => ProcessorType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options'  => [
                    'choices' => $processorsWithSocket,
                ],
            ])
                ->add('coprocessors', CollectionType::class, [
                    'entry_type' => CoprocessorType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options'  => [
                        'choices' => $coprocessorsWithSocket,
                    ],
                ]);
        };


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formPlatformModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formPlatformModifier(
                    $event->getForm(),
                    $data->getProcessorPlatformTypes(),
                    $data->getCpuSpeed(),
                    $data->getCpuSockets()
                );
            }
        );
        try {
            $builder->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) use ($formPlatformModifier) {
                    $fsbIds = (array_key_exists("cpuSpeed", $event->getData())) ? $event->getData()["cpuSpeed"] : [];
                    $processorPlatformTypeIds = (array_key_exists(
                        "processorPlatformTypes",
                        $event->getData()
                    )) ? $event->getData()["processorPlatformTypes"] : [];
                    $cpuSocketIds = (array_key_exists(
                        "cpuSockets",
                        $event->getData()
                    )) ? $event->getData()["cpuSockets"] : [];
                    $formPlatformModifier(
                        $event->getForm(),
                        new ArrayCollection($processorPlatformTypeIds),
                        new ArrayCollection($fsbIds),
                        new ArrayCollection($cpuSocketIds)
                    );

                    // since we've added the listener to the child, we'll have to pass on
                    // the parent to the callback functions!
                }
            );
        } catch (InvalidArgumentException $exception) {
            dd($exception);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Motherboard::class,
            'chipsets' => array(),
            'cpus' => array(),
            'procPlatformTypes' => array(),
            'sockets' => array(),
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['manufacturer']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getShortNameIfExist() ?? '', $b->data->getShortNameIfExist() ?? '');
        });
        usort($view->children['formFactor']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
        });

        usort($view->children["videoChipset"]->vars["choices"], function (ChoiceView $a, ChoiceView $b) {
            if (
                $a->data->getManufacturer()->getShortNameIfExist()
                ==
                $b->data->getManufacturer()->getShortNameIfExist()
            ) {
                if ($a->data->getName() == $b->data->getName()) {
                    return 0;
                } else {
                    return $a->data->getName() > $b->data->getName() ? 1 : -1;
                }
            } else {
                return $a->data->getManufacturer()->getShortNameIfExist() > $b->data->getManufacturer()->getShortNameIfExist() ? 1 : -1;
            }
        });

        usort($view->children['audioChipset']->vars["choices"], function (ChoiceView $a, ChoiceView $b) {
            if (
                $a->data->getManufacturer()->getShortNameIfExist()
                ==
                $b->data->getManufacturer()->getShortNameIfExist()
            ) {
                if ($a->data->getName() == $b->data->getName()) {
                    return 0;
                } else {
                    return $a->data->getName() > $b->data->getName() ? 1 : -1;
                }
            } else {
                return $a->data->getManufacturer()->getShortNameIfExist() > $b->data->getManufacturer()->getShortNameIfExist() ? 1 : -1;
            }
        });
    }

    /*   public function buildAfterSubmit(FormBuilderInterface $builder, array $options)
{
    /*if ($builder->getData()->getBrand() !== null) {
        $builder->add('model', EntityType::class, array(
            'class'       => 'DEERCMS\ModelBundle\Entity\Model',
            'choices'     => $models,
            'multiple' => false,
            'expanded' => false,
        ));
    }
}*/

    /*public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->children['processors']->vars['data'] = Processor::sort($view->children['processors']->vars['data']);
        foreach ($view->children['images']->children as $image)
        {
            usort($image->children['creditor']->vars['choices'], function(ChoiceView $a, ChoiceView $b) {
                return ($a->data->getName() <=> $b->data->getName());
            });
        }

        usort($view->children['cpuSpeed']->vars['choices'], function(ChoiceView $a, ChoiceView $b) {
            return ($a->data->getValue() <=> $b->data->getValue());
        });
    }*/
}
