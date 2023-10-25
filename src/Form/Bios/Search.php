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
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class Search extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    private function getManufacturerRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Manufacturer::class);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('post_string', TextType::class, [
                'required' => false,
            ])
            ->add('core_version', TextType::class, [
                'required' => false,
            ])
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'autocomplete' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
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
                'choices' => $options['moboManufacturers'],
                'placeholder' => 'Type to select a manufacturer ...',
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

        $formModifier = function (FormInterface $form, Manufacturer $chipsetManufacturer = null) {
            /**
             * @var Chipset[]
             */
            $chipsets = [];
            $chipsetManuf = $this->getManufacturerRepository()->findAllChipsetManufacturer();
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
            $form->add('chipset', ChoiceType::class, [
                'choice_label' => 'getNameCachedSearch',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $chipsets,
                'placeholder' => "Type to select a chipset ...",
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), null);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'biosManufacturers' => array(),
            'moboManufacturers' => array(),
            'expansionChips' => array(),
            'chipsetManufacturers' => array(),
        ]);
    }
}
