<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use App\Entity\ChipAlias;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Manufacturer;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class ChipAliasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ])
            ->add('name', TextType::class)
            ->add('partNumber', TextType::class, [
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChipAlias::class,
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        //dd($view->vars['form']['manufacturer']->vars['choices']);
        usort($view->vars['form']['manufacturer']->vars['choices'], function(ChoiceView $a, ChoiceView $b) {
            return ($a->data->getShortNameIfExist() > $b->data->getShortNameIfExist());
        });  
    }

}