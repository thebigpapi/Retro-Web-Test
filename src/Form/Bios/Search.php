<?php
namespace App\Form\Bios;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                //'class' => Chipset::class,

                'choice_label' => 'getShortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['chipsetManufacturers'],
		        'placeholder' => 'Select a chipset manufacturer ...',
            ])

            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,

                'choice_label' => 'shortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['biosManufacturers'],
                'placeholder' => 'Select a manufacturer ...',
            ])
            ->add('file_present', CheckboxType::class, [
                'label'    => 'File is present ?',
                'required' => false,
            ])
            ->add('search', SubmitType::class)
            ->add('searchChipsetManufacturer', SubmitType::class, ['label' => 'Search Chipset Manufacturer'])
        ;

        $formModifier = function (FormInterface $form, Manufacturer $chipsetManufacturer = null) {
            $chipsets = null === $chipsetManufacturer ? [] : $chipsetManufacturer->getChipsets()->toArray();


                usort($chipsets, function ($a, $b)
                    {
                        if ($a->getFullReference() == $b->getFullReference()) {
                            return 0;
                        }
                        return ($a->getFullReference() < $b->getFullReference()) ? -1 : 1;
                    }
                );
                $form->add('chipset', ChoiceType::class, [
                    //'class' => Chipset::class,
                    
                    'choice_label' => 'getFullReference',
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'choices' => $chipsets,
                    'placeholder' => '*',
                ]);
        };
            

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
                //dd($data);

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
            'chipsetManufacturers' => array(),
        ]);
    }
}
