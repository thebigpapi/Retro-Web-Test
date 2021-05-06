<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Processor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\Common\Collections\ArrayCollection;

class ManageProcessor extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['processors'] = Processor::sort(new ArrayCollection($options['processors']));
        $builder
        ->add('processors', EntityType::class, [
            'class' => Processor::class,
            'choice_label' => 'getNameWithSpecs',
            'multiple' => false,
            'expanded' => false,
            'choices' => $options['processors'],
        ])
        ->add('edit', SubmitType::class)
        ->add('add', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'processors' => array(),
        ]);
    }
}