<?php

namespace App\Form\Chipset;

use App\Entity\Chipset;
use App\Form\Type\ItemsPerPageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use App\Form\Type\ChipsetChipType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class Search extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('chipsetManufacturer', ChoiceType::class, [
                'choice_label' => 'getName',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'autocomplete' => true,
                'choice_attr' => function ($choice, string $key, mixed $value) {
                    if($choice == "Not identified")
                        return ['data-id' => 'NULL' ];
                    return ['data-id' => $choice->getId() ];
                },
                'choices' => $options['chipsetManufacturers'],
                'placeholder' => 'Type to select a chipset manufacturer ...',
            ])
            ->add('chips', CollectionType::class, [
                'entry_type' => ChipsetChipType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
            ->add('itemsPerPage', EnumType::class, [
                'class' => ItemsPerPageType::class,
                'empty_data' => ItemsPerPageType::Items100,
                'choice_label' => fn ($choice) => strval($choice->value),
            ])
            //->add('search', SubmitType::class)
            ;

        $formModifier = function (FormInterface $form, Manufacturer $chipsetManufacturer = null) {
            /**
             * @var Chipset[]
             */
            $chipsets = $chipsetManufacturer?->getChipsets()->toArray() ?? [];

            usort($chipsets, function (Chipset $a, Chipset $b) {
                return strnatcasecmp($a->getCachedName() ?? '', $b->getCachedName() ?? '');
            });
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

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'moboManufacturers' => array(),
            'chipsetManufacturers' => array(),
        ]);
    }
}
