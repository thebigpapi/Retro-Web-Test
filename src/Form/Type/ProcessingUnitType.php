<?php 

namespace App\Form\Type;

use App\Entity\CpuSocket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\ProcessingUnit;
use App\Entity\InstructionSet;
use App\Entity\CpuSpeed;
use App\Entity\ProcessorPlatformType;
use App\Repository\InstructionSetRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Type\InstructionSetType;
use App\Form\Type\ChipType;
use App\Form\Type\CpuSocketType;
use App\Repository\CpuSocketRepository;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ProcessingUnitType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {        
        $builder
            ->add('chip', ChipType::class, [
                'data_class' => ProcessingUnit::class,
            ])
            ->add('speed', EntityType::class, [
                'class' => CpuSpeed::class,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('platform', EntityType::class, [
                'class' => ProcessorPlatformType::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('fsb', EntityType::class, [
                'class' => CpuSpeed::class,
                'choice_label' => 'getValueWithUnit',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('instructionSets', CollectionType::class, [
                'entry_type' => InstructionSetType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('sockets', CollectionType::class, [
                'entry_type' => CpuSocketType::class,
                
                'allow_add' => true,
                'allow_delete' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->vars['form']['speed']->vars['choices'], function(ChoiceView $a, ChoiceView $b) {
            return ($a->data->getValue() > $b->data->getValue());
        });

        usort($view->vars['form']['fsb']->vars['choices'], function(ChoiceView $a, ChoiceView $b) {
            return ($a->data->getValue() > $b->data->getValue());
        });

        usort($view->vars['form']['platform']->vars['choices'], function(ChoiceView $a, ChoiceView $b) {
            return ($a->data->getName() > $b->data->getName());
        });

    }
}