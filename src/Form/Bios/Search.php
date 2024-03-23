<?php

namespace App\Form\Bios;

use App\Entity\Chipset;
use App\Form\Type\ItemsPerPageType;
use App\Form\Type\ExpansionChipType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
                return strcmp($b->getName(), $a->getName());
            }
        );
        foreach($chipsetManuf as $man){
            $any = new Chipset;
            $any->setName(" chipset of any kind");
            $any->setManufacturer($man);
            array_unshift($chipsets, $any);
        }
        $allchipsets = $this->entityManager->getRepository(Chipset::class)->findAll();
        usort(
            $allchipsets,
            function (Chipset $a, Chipset $b) {
                return strcmp($a->getNameCached(), $b->getNameCached());
            }
        );
        $chipsets = array_merge($chipsets, $allchipsets);
        return $chipsets;
    }

    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('post_string', TextType::class, [
                'required' => false,
            ])
            ->add('bios_version', TextType::class, [
                'required' => false,
            ])
            ->add('core_version', TextType::class, [
                'required' => false,
            ])
            ->add('file_name', TextType::class, [
                'required' => false,
            ])
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'autocomplete' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data-id' => 'NULL' ];
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['biosManufacturers'],
                'placeholder' => 'Type to select a manufacturer ...',
            ])
            ->add('moboManufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'autocomplete' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data-id' => 'NULL' ];
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['moboManufacturers'],
                'placeholder' => 'Type to select a manufacturer ...',
            ])
            ->add('chipset', ChoiceType::class, [
                'choice_label' => 'getNameCachedSearch',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data-id' => 'NULL' ];
                    if(strpos($choice, "any") && strpos($choice, "chipset"))
                        return ['data-id' => 0 . $choice->getManufacturer()->getId() ];
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $this->getChipsets(),
                'placeholder' => "Type to select a chipset ...",
            ])
            ->add('expansionChips', CollectionType::class, [
                'entry_type' => ExpansionChipType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('file_present', CheckboxType::class, [
                'label'    => 'File is present ?',
                'required' => false,
            ])
            ->add('itemsPerPage', EnumType::class, [
                'class' => ItemsPerPageType::class,
                'empty_data' => ItemsPerPageType::Items100,
                'choice_label' => fn ($choice) => strval($choice->value),
            ]);
    }

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'biosManufacturers' => array(),
            'moboManufacturers' => array(),
        ]);
    }
}
