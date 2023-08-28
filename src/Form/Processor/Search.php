<?php

namespace App\Form\Processor;

use App\Entity\Processor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Manufacturer;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class Search extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('cpuManufacturer', ChoiceType::class, [
                'choice_label' => 'getName',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'autocomplete' => true,
                'choices' => $options['cpuManufacturers'],
                'placeholder' => 'Select a CPU manufacturer ...',
            ])
            ->add('search', SubmitType::class);
        $formModifier = function (FormInterface $form, Manufacturer $cpuManufacturer = null) {
                /**
                 * @var Processor[]
                 */

            };

            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formModifier) {
                    // this would be your entity, i.e. SportMeetup
                    $data = $event->getData();

                    $formModifier($event->getForm(), null);
                }
            );

            $builder->get('cpuManufacturer')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier) {
                    // It's important here to fetch $event->getForm()->getData(), as
                    // $event->getData() will get you the client data (that is, the ID)
                    $cpuManufacturer = $event->getForm()->getData();
                    // since we've added the listener to the child, we'll have to pass on
                    // the parent to the callback functions!
                    $formModifier($event->getForm()->getParent(), $cpuManufacturer);
                }
            );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'cpuManufacturers' => array(),
        ]);
    }
}
