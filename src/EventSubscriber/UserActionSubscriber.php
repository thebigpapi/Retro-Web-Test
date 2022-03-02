<?php

namespace App\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserActionSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function getSubscribedEvents(): array {
        //dd($this->security->getUser());
        return [
            'postPersist',
            'preUpdate',
            'postDelete',
        ];
    }

    public function postPersist(LifecycleEventArgs $args) {
        dd($args);
    }

    public function preUpdate(LifecycleEventArgs $args) {
        //dd($args);
        $username = $this->security->getUser()->getUsername();
        $object = $args->getObject();
        $type = $object::class;
        //$args->getEntityChangeSet();
        $string = "{$username} changed the object {$type} with id {$object->getId()}";
        dd($string);
    }

    public function postDelete(LifecycleEventArgs $args) {
        dd($args);
    }
}