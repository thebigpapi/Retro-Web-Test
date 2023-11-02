<?php

namespace App\Form\Type;

use App\Entity\LargeFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\LargeFileMotherboard;
use App\Repository\LargeFileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

class LargeFileMotherboardType extends AbstractType
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getLargeFileRepository(): LargeFileRepository
    {
        return $this->entityManager->getRepository(LargeFile::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $largeFiles = $this->getLargeFileRepository()->findAllOptimized();
        $builder
            ->add('isRecommended', CheckboxType::class, [
                'required' => false,
            ])
            ->add('largeFile', EntityType::class, [
                'class' => LargeFile::class,
                'required' => false,
                'choice_label' => 'getNameWithTags',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['data-ea-widget' => 'ea-autocomplete'],
                'choices' => $largeFiles,
                'placeholder'=> 'Type to select a driver ...',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LargeFileMotherboard::class,
        ]);
    }
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view->children['largeFile']->vars['choices'], function (ChoiceView $a, ChoiceView $b) {
            return strnatcasecmp($a->data->getName() ?? '', $b->data->getName() ?? '');
        });
    }
}
