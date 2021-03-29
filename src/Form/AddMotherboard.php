<?php
namespace App\Form;

use App\Entity\Motherboard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
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
use App\Entity\MaxRam;
use App\Form\Type\ProcessorType;
use App\Form\Type\CoprocessorType;
use App\Form\Type\ProcessorSpeedType;
use App\Form\Type\MotherboardExpansionSlotType;
use App\Form\Type\MotherboardAliasType;
use App\Form\Type\MotherboardIoPortType;
use App\Form\Type\MotherboardMaxRamType;
use App\Form\Type\CacheSizeType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ManualType;
use App\Form\Type\MotherboardBiosType;
use App\Form\Type\MotherboardImageTypeForm;
use App\Form\Type\KnownIssueType;
use App\Form\Type\ProcessorPlatformTypeForm;
use App\Repository\ProcessorPlatformTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Process\Process;


class AddMotherboard extends AbstractType
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
                
                'choice_label' => 'getMainChipWithManufacturer',
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
            /*->add('processorPlatformType', EntityType::class, [
                'class' => ProcessorPlatformType::class,
                
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['procPlatformTypes'],
            ])*/
            ->add('coprocessors', CollectionType::class, [
                'entry_type' => CoprocessorType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
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
            ->add('dramType', EntityType::class, [
                'class' => DramType::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
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
            ->add('note', TextareaType::class, [
                'required' => false,
            ])
            ->add('maxCpu', NumberType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class)
        ;

        $formSocketModifier = function (FormInterface $form, Collection $cpuSockets = null) {
            if($cpuSockets->isEmpty()) {
                //dd("test");
                $platforms = $this->getProcessorPlatformTypeRepository()
                ->findAll();
            }
            else {
                $platforms = array();
                foreach ($cpuSockets as $socket) {
                    $platforms = array_merge($platforms,$socket->getPlatforms()->toArray());
                }
            }
            //dd($platforms);
           
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
               /*usort($processors, function ($a, $b)
                    {
                        if ($a->getFullReference() == $b->getFullReference()) {
                            return 0;
                        }
                        if($a->getFullReference()==" Unidentified ") return -1;
                        return ($a->getFullReference() < $b->getFullReference()) ? -1 : 1;
                    }
                );*/
                
                //if($chipsetManufacturer) dd($chipsets[94]->getFullReference()==" Unidentified ");
                /*$form->add('processors', CollectionType::class, [
                    'entry_type' => ProcessorType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options'  => [
                        'choices' => $processors,
                    ],
                ]);*/
                /*$form->add('processorPlatformTypes', EntityType::class, [
                    'class' => ProcessorPlatformType::class,
                    
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => $platforms,
                ]);*/
                $form->add('processorPlatformTypes', CollectionType::class, [
                    'entry_type' => ProcessorPlatformTypeForm::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options'  => [
                        'choices' => $platforms,
                    ],
                ]);
            //}
            /*if($chipsetManufacturer)
                dd($form->getData());*/
        };
            

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formSocketModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                //dd($data->getCpuSockets());

                $formSocketModifier($event->getForm(), $data->getCpuSockets());
            }
        );

        $builder->get('cpuSockets')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formSocketModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $cpuSockets = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formSocketModifier($event->getForm()->getParent(), $cpuSockets);
            }
        );

        $formPlatformModifier = function (FormInterface $form, Collection $processorPlatformTypes = null) {
            //$processors = null === $processorPlatformTypes ? [] : $processorPlatformTypes->getCompatibleProcessingUnits()->toArray();
            $processors = array();
            if (!$processorPlatformTypes->isEmpty()) {
                foreach ($processorPlatformTypes as $platform) {
                    $processors = array_merge($processors, $platform->getCompatibleProcessors()->toArray());
                }
            }
            
            
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
               /*usort($processors, function ($a, $b)
                    {
                        if ($a->getFullReference() == $b->getFullReference()) {
                            return 0;
                        }
                        if($a->getFullReference()==" Unidentified ") return -1;
                        return ($a->getFullReference() < $b->getFullReference()) ? -1 : 1;
                    }
                );*/
                $processors = Processor::sort(new ArrayCollection($processors));
                //if($chipsetManufacturer) dd($chipsets[94]->getFullReference()==" Unidentified ");
                $form->add('processors', CollectionType::class, [
                    'entry_type' => ProcessorType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options'  => [
                        'choices' => $processors,
                    ],
                ]);
            //}
            /*if($chipsetManufacturer)
                dd($form->getData());*/
        };
            

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formPlatformModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                //dd($data);

                $formPlatformModifier($event->getForm(), $data->getProcessorPlatformTypes());
            }
        );

        try {
            $builder->get('processorPlatformType')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formPlatformModifier) {
                    // It's important here to fetch $event->getForm()->getData(), as
                    // $event->getData() will get you the client data (that is, the ID)
                    $processorPlatformTypes = $event->getForm()->getData();

                    // since we've added the listener to the child, we'll have to pass on
                    // the parent to the callback functions!
                    $formPlatformModifier($event->getForm()->getParent(), $processorPlatformTypes);
                }
            );
        }
        catch (InvalidArgumentException $exception) {}
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

}