<?php

namespace App\Form\Type;

use App\Entity\LargeFileOsFlag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\OsFlag;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class LargeFileOsFlagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unsure', CheckboxType::class)
            ->add('osFlag', EntityType::class, [
                'class' => OsFlag::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LargeFileOsFlag::class,
        ]);
    }
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        //dd($view->children['osFlag']->vars['choices']);
        usort($view->children['osFlag']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
        });
    }
}
