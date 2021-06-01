<?php
namespace App\Form;

use App\Entity\Motherboard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use App\Entity\CacheSize;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ManageCacheSize extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('cacheSizes', EntityType::class, [
            'class' => CacheSize::class,
            'choice_label' => 'valueWithUnit',
            'multiple' => false,
            'expanded' => false,
            'choices' => $options['cacheSizes'],
        ])
        ->add('edit', SubmitType::class)
        ->add('add', SubmitType::class)
        ->add('delete', SubmitType::class, [
            'attr' => ['class' => 'delbtn'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'cacheSizes' => array(),
        ]);
    }
}