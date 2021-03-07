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
use App\Entity\MaxRam;
use App\Form\Type\ProcessorType;
use App\Form\Type\CoprocessorType;
use App\Form\Type\ProcessorSpeedType;
use App\Form\Type\MotherboardExpansionSlotType;
use App\Form\Type\MotherboardAliasType;
use App\Form\Type\MotherboardIoPortType;
use App\Form\Type\MotherboardMaxRamType;
use App\Form\Type\CacheSizeType;
use App\Form\Type\ManualType;
use App\Form\Type\MotherboardBiosType;
use App\Form\Type\MotherboardImageTypeForm;
use App\Form\Type\KnownIssueType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class AddMotherboard extends AbstractType
{
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
            ->add('processorPlatformType', EntityType::class, [
                'class' => ProcessorPlatformType::class,
                
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['procPlatformTypes'],
            ])
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

        $formModifier = function (FormInterface $form, ProcessorPlatformType $processorPlatformType = null) {
            $processors = null === $processorPlatformType ? [] : $processorPlatformType->getCompatibleProcessingUnits()->toArray();
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
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                //dd($data);

                $formModifier($event->getForm(), $data->getProcessorPlatformType());
            }
        );

        $builder->get('processorPlatformType')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $processorPlatformType = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $processorPlatformType);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Motherboard::class,
            'chipsets' => array(),
            'cpus' => array(),
            'procPlatformTypes' => array(),
        ]);
    }

}