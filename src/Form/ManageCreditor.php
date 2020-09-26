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
use App\Entity\Creditor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ManageCreditor extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('creditors', EntityType::class, [
            'class' => Creditor::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded' => false,
            'choices' => $options['creditors'],
        ])
        ->add('edit', SubmitType::class)
        ->add('add', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'creditors' => array(),
        ]);
    }
}