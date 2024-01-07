<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\StorageDeviceIdRedirection;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StorageDeviceIdRedirectionType extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('source', TextType::class, [
                'required' => true,
            ])
            ->add('sourceType', ChoiceType::class, [
                'choices'  => [
                    'TRW' => 'trw',
                    'TH99' => 'th99',
                    'Slug' => 'trw_slug',
                ]
            ]);
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StorageDeviceIdRedirection::class,
        ]);
    }
}
