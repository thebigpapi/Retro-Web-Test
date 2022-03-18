<?php

namespace App\EventSubscriber;

use App\Entity\Trace;
use App\Repository\TraceRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserActionSubscriber implements EventSubscriberInterface
{

    public function __construct(private Security $security, private EntityManagerInterface $entityManager) {}

    public function getSubscribedEvents(): array {
        //dd($this->security->getUser());
        return [
            /*'postPersist',
            'preUpdate',
            'postUpdate',
            'preRemove',*/
        ];
    }

    public function postPersist(LifecycleEventArgs $args) {
        $object = $args->getObject();

        if($object instanceof Trace) { //Exclude trace to avoid infinite loop
            return;
        }

        $trace = new Trace();
        $trace->setUsername($this->security->getUser()->getUserIdentifier());
        $trace->setEventType("CREATE");
        $trace->setObjectType($object::class);
        if(method_exists($object, 'getId')){
            $trace->setObjectId($object->getId());
        }

        $trace->setContent(str_replace(["App\\\\Entity\\\\", "\u0000"], "", json_encode((array) $object, JSON_PRETTY_PRINT)));
        $trace->setDate(date_create());

        $this->entityManager->persist($trace);
        $this->entityManager->flush();
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $object = $args->getObject();

        if($object instanceof Trace) { //Exclude trace to avoid infinite loop
            return;
        }

        $trace = new Trace();
        $trace->setUsername($this->security->getUser()->getUserIdentifier());
        $trace->setEventType("UPDATE");
        $trace->setObjectType($object::class);
        if(method_exists($object, 'getId')){
            $trace->setObjectId($object->getId());
        }

        $trace->setContent(str_replace(["App\\\\Entity\\\\", "\u0000"], "", json_encode((array) $args->getEntityChangeSet(), JSON_PRETTY_PRINT)));
        $trace->setDate(date_create());

        $this->entityManager->persist($trace);
        
    }

    public function postUpdate() {
        $this->entityManager->flush();
    }

    public function preRemove(LifecycleEventArgs $args) {
        $object = $args->getObject();
        
        
        if($object instanceof Trace) { //Exclude trace to avoid infinite loop
            return;
        }

        $trace = new Trace();
        $trace->setUsername($this->security->getUser()->getUserIdentifier());
        $trace->setEventType("DELETE");
        $trace->setObjectType($object::class);
        if(method_exists($object, 'getId')){
            $trace->setObjectId($object->getId());
        }

        $trace->setContent(str_replace(["App\\\\Entity\\\\", "\u0000"], "", json_encode((array) $object, JSON_PRETTY_PRINT)));
        $trace->setDate(date_create());

        $this->entityManager->persist($trace);
        $this->entityManager->flush();
    }
}