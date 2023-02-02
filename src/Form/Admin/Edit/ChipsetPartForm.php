<?php

namespace App\Form\Admin\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\ChipsetPart;
use App\Form\Type\ChipType;
use App\Form\Type\ChipDocumentationType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class ChipsetPartForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chip', ChipType::class, [
                'data_class' => ChipsetPart::class,
            ])
            ->add('documentations', CollectionType::class, [
                'entry_type' => ChipDocumentationType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('rank', NumberType::class, [
                'required' => true,
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChipsetPart::class,
        ]);
    }
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['chip']->children['manufacturer']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp(
                $a->data->getShortNameIfExist(),
                $b->data->getShortNameIfExist()
            );
        });
    }
}
