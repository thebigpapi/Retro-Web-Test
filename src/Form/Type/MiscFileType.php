<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\MiscFile;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MiscFileType extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link_name', TextType::class, [
                'label' => 'Title',
            ])
            ->add('miscFile', VichFileType::class, [
                'label' => 'File',
                'allow_delete' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '64Mi',
                    ])
                ],
            ]);
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MiscFile::class,
        ]);
    }
}
