<?php

namespace App\Form\Admin\Edit;

use App\Entity\DumpQualityFlag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\LargeFile;
use App\Form\Type\LanguageType;
use App\Form\Type\LargeFileMediaTypeFlagType;
use App\Form\Type\LargeFileOsFlagType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LargeFileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
            ])
            ->add('file_name', TextType::class, [
                'required' => false,
                'disabled' => true,
            ])
            ->add('file', FileType::class, [
                'label' => 'File (zip file)',

                // unmapped means that this field is not associated to any entity property
                //'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '8192M',
                    ])
                ],
            ])
            ->add('dumpQualityFlag', EntityType::class, [
                'class' => DumpQualityFlag::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            ->add('languages', CollectionType::class, [
                'entry_type' => LanguageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('mediaTypeFlags', CollectionType::class, [
                'entry_type' => LargeFileMediaTypeFlagType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('osFlags', CollectionType::class, [
                'entry_type' => LargeFileOsFlagType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('hasActivationKey', CheckboxType::class, [
                'required' => false,
            ])
            ->add('hasCopyProtection', CheckboxType::class, [
                'required' => false,
            ])
            ->add('fileVersion', TextType::class, [
                'required' => false,
            ])
            ->add('note', TextareaType::class, [
                'required' => false,
            ])
            ->add('idpci', TextareaType::class, [
                'required' => false,
            ])
            ->add('subdirectory', ChoiceType::class, [
                'choices' => array(
                    'apps' => 'apps',
                    'docs' => 'docs',
                    'oswin' => 'oswin',
                    'vm' => 'vm',
                    'bootdisks' => 'bootdisks',
                    'drivers' => 'drivers',
                    'games' => 'games',
                    'osdos' => 'osdos',
                    'dev' => 'dev',
                    'osmisc' => 'osmisc'
                ),
                'placeholder' => 'Please select a directory',
                'required' => true,
            ])
            ->add('releaseDate', DateType::class, [
                'widget' => 'text',
                'format' => 'yyyy-MM-dd',
                'required' => true,
            ])
            ->add('datePrecision', ChoiceType::class, [
                'choices'  => [
                    "Year only" => 'y',
                    "Year and month" => 'm',
                    "Full date" => 'd',
                ],
            ])
            ->add('save', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LargeFile::class,
        ]);
    }
}
