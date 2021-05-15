<?php
namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\Chipset;
use App\Entity\Manufacturer;
use App\Form\Type\ChipsetBiosCodeType;
use App\Form\Type\ChipsetPartType;
use App\Form\Type\LargeFileChipsetType;
use App\Form\Type\LargeFileType;

class ChipsetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['chipsetManufacturers'],
            ])
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('part_no', TextType::class, [
                'required' => false,
            ])
            ->add('encyclopedia_link', TextType::class, [
                'required' => false,
            ])
            ->add('release_date', TextType::class, [
                'required' => false,
            ])
            ->add('chipsetParts', CollectionType::class, [
                'entry_type' => ChipsetPartType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options'  => [
                    'choices' => $options['chipsetParts'],
                ],
            ])
            ->add('biosCodes', CollectionType::class, [
                'entry_type' => ChipsetBiosCodeType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('drivers', CollectionType::class, [
                'entry_type' => LargeFileChipsetType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])

            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chipset::class,
            'chipsetManufacturers' => array(),
            'chipsetParts' => array(),
        ]);
    }
}