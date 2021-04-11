<?php

namespace App\EventSubscriber\Form;

use App\Repository\CpuSocketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Test\FormInterface;

class AddCpuSocketSubscriber implements EventSubscriberInterface
{
    private $factory;
    private $entityManager;

    public function __construct(FormFactoryInterface $factory, EntityManagerInterface $entityManager) {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    private function getCpuSockets(): CpuSocketRepository
    {
        return $this->entityManager->getRepository(CpuSocketRepository::class);
    }

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        );
    }

    private function addSocketForm(FormInterface $form) {
        $form->add('cpuSockets', CollectionType::class, [
            'entry_type' => CpuSocketType::class,
            
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options'  => [
                'choices' => $this->getCpuSockets(),
            ]
        ]);
    }

    public function preSetData(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        if (null === $data)
            return;

        //$fieldName = 'get' . ucwords($this->type) . 'Suburb';
        //$province = ($data->$fieldName()) ? $data->$fieldName()->getCity()->getProvince() : null;
        $this->addSocketForm($form);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        if (null === $data)
            return;

        //$province = array_key_exists($this->fieldName, $data) ? $data[$this->fieldName] : null;
        $this->addSocketForm($form);
    }
}