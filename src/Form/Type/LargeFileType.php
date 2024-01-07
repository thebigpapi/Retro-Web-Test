<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\LargeFile;

class LargeFileType extends AbstractType
{

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => LargeFile::class,
            'choice_label' => 'getNameWithTags',
            'multiple' => false,
            'expanded' => false,
        ]);
    }

    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
