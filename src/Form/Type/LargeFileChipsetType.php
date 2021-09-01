<?php
namespace App\Form\Type;

use App\Entity\LargeFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\LargeFileChipset;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class LargeFileChipsetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isRecommended', CheckboxType::class, [
                'required' => false,
            ])
            ->add('largeFile', EntityType::class, [
                'class' => LargeFile::class,
                'required' => false,
                'choice_label' => 'getNameWithTags',
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LargeFileChipset::class,
        ]);
    }

}