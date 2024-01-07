<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\IoPort;

class SearchMotherboardIoPortType extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('io_port', EntityType::class, [
                'class' => IoPort::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                ])
            ->add('count', NumberType::class);
    }
}
