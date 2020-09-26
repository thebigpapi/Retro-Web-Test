<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use App\Entity\Chipset;
use App\Entity\DramType;
use App\Entity\FormFactor;
use App\Entity\ProcessorPlatformType;
use App\Entity\MaxRam;
use App\Form\Type\SearchMotherboardExpansionSlotType;
use App\Form\Type\SearchMotherboardIoPortType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SearchMotherboard extends AbstractType
{
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
            ->add('chipset', ChoiceType::class, [
                //'class' => Chipset::class,
                
                'choice_label' => 'getMainChipWithManufacturer',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['chipsets'],
		        'placeholder' => 'Select a chipset ...',
            ])
            /*->add('searchProcessorPlatformType', CheckboxType::class, [
                'label'    => ' ',
                'required' => false,
            ])*/
            ->add('processorPlatformType', ChoiceType::class, [
                //'class' => ProcessorPlatformType::class,
                
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['procPlatformTypes'],
		        'placeholder' => 'Select a processor platform ...',
            ])
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
            ->add('motherboardBios', EntityType::class, [
                'class' => Manufacturer::class,

                'choice_label' => 'shortNameIfExist',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'choices' => $options['bios'],
            ])
            ->add('search', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'moboManufacturers' => array(),
            'chipsets' => array(),
            'bios' => array(),
            'formFactors' => array(),
            'procPlatformTypes' => array(),
        ]);
    }
}
