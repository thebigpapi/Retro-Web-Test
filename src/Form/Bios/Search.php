<?php

namespace App\Form\Bios;

use App\Entity\Chipset;
use App\Form\Type\ItemsPerPageType;
use App\Form\Type\ExpansionChipType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use App\Entity\ExpansionChip;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class Search extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('post_string', TextType::class, [
                'required' => false,
            ])
            ->add('core_version', TextType::class, [
                'required' => false,
            ])
            ->add('chipsetManufacturer', ChoiceType::class, [
                'choice_label' => 'getName',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'autocomplete' => true,
                'choices' => $options['chipsetManufacturers'],
                'placeholder' => 'Type to select a chipset manufacturer ...',
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
            $chipsets = $chipsetManufacturer?->getChipsets()->toArray() ?? [];

            usort($chipsets, function (Chipset $a, Chipset $b) {
                return strnatcasecmp($a->getNameCached() ?? '', $b->getNameCached() ?? '');
            });
            $chipTag = null === $chipsetManufacturer ? "No chipset selected!" : "Type to select any " . $chipsetManufacturer->getName() . " chipset ...";
            $form->add('chipset', ChoiceType::class, [
                'choice_label' => 'getNameCached',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $chipsets,
                'placeholder' => $chipTag,
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


        $builder->get('chipsetManufacturer')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $chipsetManufacturer = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $chipsetManufacturer);
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
