<?php

namespace App\Form\Chipset;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;

class Search extends AbstractType
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('chipsetManufacturer', ChoiceType::class, [
                'choice_label' => 'getShortNameIfExist',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $options['chipsetManufacturers'],
                'placeholder' => 'Select a chipset manufacturer ...',
            ])
            ->add('search', SubmitType::class)
            ->add('searchWithImages', SubmitType::class);

            $formModifier = function (FormInterface $form, Manufacturer $chipsetManufacturer = null) {
            $chipsets = null === $chipsetManufacturer ? [] : $chipsetManufacturer->getChipsets()->toArray();

            usort(
                $chipsets,
                function ($a, $b) {
                    if ($a->getFullReference() == $b->getFullReference()) {
                        return 0;
                    }
                    if ($a->getFullReference() == " Unidentified ") return -1;
                    return ($a->getFullReference() < $b->getFullReference()) ? -1 : 1;
                }
            );
            //if($chipsetManufacturer) dd($chipsets[94]->getFullReference()==" Unidentified ");
            //}
            /*if($chipsetManufacturer)
                dd($form->getData());*/
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
            'chipsetManufacturers' => array(),
        ]);
    }
}
