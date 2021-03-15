<?php

namespace App\Listener;

use App\Entity\ChipImage;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Motherboard;
use App\Entity\MotherboardImage;
use Doctrine\ORM\Event\PreUpdateEventArgs;

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

    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof MotherboardImage && !$entity instanceof ChipImage){
            return;
        }
        //dd($entity);
        //dd($this->uploaderHelper->asset($entity, 'imageFile'));
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof MotherboardImage && !$entity instanceof ChipImage){
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