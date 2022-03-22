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

    private array $removedObjects;

    public function __construct(private Security $security, private EntityManagerInterface $entityManager) {
        $removedObjects = array();
    }

    public function getSubscribedEvents(): array {
        return [
            'postPersist',
            'preUpdate',
            'postUpdate',
            'preRemove',
            'postRemove',
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
        $search = "/[^0000](.*)[^0000]/";
        $search = '#(0000).*?(0000)#';
        $trace->setContent(str_replace("\u", "", preg_replace($search,"\u",json_encode((array) $object, JSON_PRETTY_PRINT))));
        $trace->setDate(date_create());
        dd($object);
        dd(json_encode((array) $object, JSON_PRETTY_PRINT, 3));
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
        //echo($object);
        //echo("obj obj2");
        //dd($args);
        $search = "/[^0000](.*)[^0000]/";
        $search = '#(0000).*?(0000)#';
        $trace->setContent(str_replace("\u", "", preg_replace($search,"\u",json_encode((array) $args->getEntityChangeSet(), JSON_PRETTY_PRINT))));
        $trace->setDate(date_create());
        //echo($args);
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

        $this->removedObjects[] = clone $object;
    }

    public function postRemove() {
        foreach ($this->removedObjects as $object) {
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
        }

        $this->entityManager->flush();
    }
}