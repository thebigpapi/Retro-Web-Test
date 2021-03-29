<?php 

namespace App\Form\Type;

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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ProcessingUnitType extends AbstractType
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getManufacturerRepository(): InstructionSetRepository
    {
        return $this->entityManager->getRepository(InstructionSet::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $instructionSets = $this->getManufacturerRepository()
        ->findBy(array(), array('name' => 'ASC'));

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
                'entry_options'  => [
                    'choices' => $instructionSets,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }
}