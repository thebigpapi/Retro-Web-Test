<?php

namespace App\Form\Type;

use App\Entity\ExpansionChip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\LargeFileExpansionChip;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class ExpansionChipLargeFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isRecommended', CheckboxType::class, [
                'required' => false,
            ])
            ->add('expansionChip', EntityType::class, [
                'class' => ExpansionChip::class,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'required' => false,
                'choice_label' => 'getNameWithManufacturer',
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LargeFileExpansionChip::class,
        ]);
    }
}
