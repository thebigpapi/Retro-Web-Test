<?php

namespace App\EventSubscriber;

use App\Entity\Chipset;
use App\Entity\ChipsetPart;
use EasyCorp\Bundle\EasyAdminBundle\Event\AbstractLifecycleEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ChipsetNameCacheSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setChipsetCacheNameSlug'],
            BeforeEntityUpdatedEvent::class => ['setChipsetCacheNameSlug'],
            BeforeEntityDeletedEvent::class => ['setChipsetCacheNameSlug'],
        ];
    }

    public function setChipsetCacheNameSlug(AbstractLifecycleEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (($entity instanceof Chipset)) {
            $this->chipsetChanged($entity);
        } elseif (($entity instanceof ChipsetPart)) {
            $this->chipsetPartChanged($entity);
        }
    }

    private function chipsetPartChanged(ChipsetPart $chipsetPart) {
        foreach($chipsetPart->getChipsets() as $chispet) {
            $chispet->updateCachedName();
        }
    }

    private function chipsetChanged(Chipset $chispet) {
        $chispet->updateCachedName();
    }
}