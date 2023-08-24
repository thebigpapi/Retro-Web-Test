<?php

namespace App\Form\Admin\Edit;

use App\Entity\DumpQualityFlag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\LargeFile;
use App\Form\Type\LanguageType;
use App\Form\Type\LargeFileMediaTypeFlagType;
use App\Form\Type\OsFlagType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichFileType;

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
            ->add('file', VichFileType::class, [
                'label' => 'File (zip file)',
                'required' => false,
                'allow_delete' => false,
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
                'entry_type' => OsFlagType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('fileVersion', TextType::class, [
                'required' => false,
            ])
            ->add('note', TextareaType::class, [
                'required' => false,
            ])
            ->add('subdirectory', ChoiceType::class, [
                'choices' => array(
                    'apps' => 'apps',
                    'drivers' => 'drivers',
                ),
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
