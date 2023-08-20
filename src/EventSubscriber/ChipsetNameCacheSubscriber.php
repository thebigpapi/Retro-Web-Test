<?php

namespace App\EventSubscriber;

use App\Entity\Chipset;
use App\Entity\ChipsetPart;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AbstractLifecycleEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ChipsetNameCacheSubscriber implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setChipsetCachedName'],
            BeforeEntityUpdatedEvent::class => ['setChipsetCachedName'],
            BeforeEntityDeletedEvent::class => ['setChipsetCachedName'],
        ];
    }

    public function setChipsetCachedName(AbstractLifecycleEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (($entity instanceof Chipset)) {
            $this->chipsetChanged($entity);
        } elseif (($entity instanceof ChipsetPart)) {
            $this->chipsetPartChanged($entity);
        }
    }

    private function chipsetPartChanged(ChipsetPart $chipsetPart) {
        foreach($chipsetPart->getChipsets() as $chipset) {
            $this->entityManager->persist($chipset);
        }
    }

    private function chipsetChanged(Chipset $chispet) {
        $chispet->updateCachedName();
    }
}