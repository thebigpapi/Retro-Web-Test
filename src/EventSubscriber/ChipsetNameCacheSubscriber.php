<?php

namespace App\EventSubscriber;

use App\Entity\Chipset;
use App\Entity\ExpansionChip;
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

    /**
     * @return array
     */
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
        } elseif (($entity instanceof ExpansionChip) && $entity->getType()->getId() == 30) {
            $this->chipsetPartChanged($entity);
        }
    }

    private function chipsetPartChanged(ExpansionChip $chipsetPart) {
        foreach($chipsetPart->getChipsets() as $chipset) {
            $this->entityManager->persist($chipset);
        }
    }

    private function chipsetChanged(Chipset $chipset) {
        $chipset->updateCachedName();
    }
}