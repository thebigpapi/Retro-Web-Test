<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Manufacturer;
use App\Entity\ChipsetBiosCode;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ChipsetBiosCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('biosManufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'name',
                'label' => 'Chipset manufacturer',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete']
                ])
            ->add('code', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChipsetBiosCode::class,
        ]);
    }
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['biosManufacturer']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
        });
    }
}
