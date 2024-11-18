<?php

namespace App\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class HexType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->addModelTransformer(new CallbackTransformer(
                static fn ($number) => $number !== null ?strtoupper(str_pad(dechex($number), 4, "0", STR_PAD_LEFT)):null,
                static fn ($hexString) => (!preg_match("/^[\da-fA-F]{4}$/", $hexString)) ? 'a' : hexdec($hexString)
            ));
    }
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['pattern'] = null;
        unset($view->vars['attr']['pattern']);
    }

    public function getParent(): ?string
    {
        return TextType::class;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'compound' => false
        ]);
    }
    public function getBlockPrefix(): string
    {
        return 'hex';
    }

}