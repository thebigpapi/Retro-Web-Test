<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ManageUser extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('users', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'getUsername',
            'multiple' => false,
            'expanded' => false,
        ])
        ->add('reset', SubmitType::class)
        ->add('add', SubmitType::class)
        ->add('delete', SubmitType::class)
        ;
    }
}
