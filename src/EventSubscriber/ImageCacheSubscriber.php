<?php

namespace App\EventSubscriber;

use App\Entity\ChipImage;
use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\MotherboardImage;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;

class ImageCacheSubscriber implements EventSubscriber
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents(): array
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(PreRemoveEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof MotherboardImage && !$entity instanceof ChipImage) {
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof MotherboardImage && !$entity instanceof ChipImage) {
            return;
        }

        if ($entity->getImageFile() instanceof UploadedFile) {
            //Restoring entity as it used to be
            $prevEntity = clone $entity;

            $prevEntity->setFileName($args->getEntityChangeSet()["file_name"][0]);
            $prevEntity->setImageFile(null);
            $this->cacheManager->remove($this->uploaderHelper->asset($prevEntity, 'imageFile'));
        }
    }
}
