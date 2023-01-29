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
            //'preRemove',
            //'postRemove',
        ];
    }

    public function postPersist(LifecycleEventArgs $args) {
        $object = $args->getObject();
        if($object instanceof Trace) {
            return;
        }
        $this->write_trace($object, "CREATE", $args);
        $this->entityManager->flush();
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $object = $args->getObject();
        if($object instanceof Trace) {
            return;
        }
        $this->write_trace($object, "UPDATE", $args);
    }

    public function postUpdate() {
        $this->entityManager->flush();
    }

    public function preRemove(LifecycleEventArgs $args) {
        $object = $args->getObject();
        if($object instanceof Trace) {
            return;
        }
        $allowed = ["App\Entity\Motherboard"];
        if(in_array(get_class($object), $allowed)){
            if(method_exists($object, 'getId')){
                $this->write_trace($object, "DELETE", $args);
            }
        }     
    }

    public function postRemove() {
        $this->entityManager->flush();
    }

    public function jsonify(array $object){
        $search = "/[^0000](.*)[^0000]/";
        $search = '#(0000).*?(0000)#';
        return str_replace("\u", "", preg_replace($search,"\u",json_encode($object, JSON_PRETTY_PRINT)));
    }

    public function write_trace($object, $type, $args){
        $trace = new Trace();
        $trace->setUsername($this->security->getUser()->getUserIdentifier());
        $trace->setEventType($type);
        $trace->setObjectType($object::class);
        if(method_exists($object, 'getId')){
            $trace->setObjectId($object->getId());
        }
        if($type == "UPDATE"){
            $trace->setContent($this->jsonify((array) $args->getEntityChangeSet()));
        }
        else{
            $trace->setContent($this->jsonify((array) $object));
        }
        $trace->setDate(date_create());
        $this->entityManager->persist($trace);
    }
}