<?php

namespace App\Form\Motherboard;

use App\Entity\Chipset;
use App\Form\Type\DramTypeType;
use App\Form\Type\ExpansionSlotSearchType;
use App\Form\Type\IoPortSearchType;
use App\Form\Type\ExpansionChipType;
use App\Form\Type\ItemsPerPageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Entity\Manufacturer;
use App\Entity\CpuSocket;
use App\Entity\FormFactor;
use Doctrine\ORM\EntityManagerInterface;

class Search extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getChipsets(): array
    {
        $chipsets = [];
        $chipsetManuf = $this->entityManager->getRepository(Manufacturer::class)->findAllChipsetManufacturer();
        usort(
            $chipsetManuf,
            function (Manufacturer $a, Manufacturer $b) {
                return strcmp($a->getName(), $b->getName());
            }
        );
        foreach($chipsetManuf as $man){
            $cm = $man->getChipsets()->toArray() ?? [];
            $any = new Chipset;
            $any->setName(" chipset of any kind");
            $any->setManufacturer($man);
            array_unshift($cm, $any);
            $chipsets = array_merge($chipsets, $cm);
        }
        usort(
            $chipsets,
            function (Chipset $a, Chipset $b) {
                return strcmp($a->getNameCached(), $b->getNameCached());
            }
        );
        return $chipsets;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // sorting some fields before adding them to the form
        usort($options['cpuSockets'], function (CpuSocket $a, CpuSocket  $b) {
            if (!$a->getName() && !$b->getName()) {
                return strnatcasecmp($a->getType() ?? '', $b->getType() ?? '');
            } else {
                return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
            }
        });

        usort($options['formFactors'], function (FormFactor $a, FormFactor $b) {
            return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
        });

        //now the form is being built
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('manufacturer', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['moboManufacturers'],
                'placeholder' => 'Type to select a manufacturer ...'
            ])
            ->add('chipset', ChoiceType::class, [
                'choice_label' => 'getNameCachedSearch',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $this->getChipsets(),
                'placeholder' => "Type to select a chipset ...",
            ])
            ->add('expansionChips', CollectionType::class, [
                'entry_type' => ExpansionChipType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('dramTypes', CollectionType::class, [
                'entry_type' => DramTypeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('cpuSocket1', ChoiceType::class, [
                'choice_label' => 'getNameAndType',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['cpuSockets'],
                'placeholder' => 'Type to select a socket ...',
            ])
            ->add('cpuSocket2', ChoiceType::class, [
                'choice_label' => 'getNameAndType',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['cpuSockets'],
                'placeholder' => 'Type to select a socket ...',
            ])
            ->add('platform1', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['procPlatformTypes'],
                'placeholder' => 'Type to select a processor family ...',
            ])
            ->add('platform2', ChoiceType::class, [
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['procPlatformTypes'],
                'placeholder' => 'Type to select a processor family ...',
            ])
            ->add('formFactor', ChoiceType::class, [
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'choices' => $options['formFactors'],
                'placeholder' => 'Type to select a form factor ...',
            ])
            ->add('motherboardExpansionSlots', CollectionType::class, [
                'entry_type' => ExpansionSlotSearchType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('motherboardIoPorts', CollectionType::class, [
                'entry_type' => IoPortSearchType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('searchWithImages', CheckboxType::class, [
                'data' => true,
                'label' => false,
                'attr' => array('checked' => 'checked'),
            ])
            ->add('itemsPerPage', EnumType::class, [
                'class' => ItemsPerPageType::class,
                'empty_data' => ItemsPerPageType::Items100,
                'choice_label' => fn ($choice) => strval($choice->value),
            ])
            ->add('page', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'value' => 1,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'moboManufacturers' => array(),
            'chipsetManufacturers' => array(),
            'bios' => array(),
            'formFactors' => array(),
            'procPlatformTypes' => array(),
            'cpuSockets' => array(),
        ]);
    }
}
