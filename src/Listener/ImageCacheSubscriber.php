<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Motherboard;
use App\Entity\MotherboardImage;

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

    public function preRemove(LifecycleEventArgs  $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof MotherboardImage){
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        /*if (!$args->getEntity() instanceof Motherboard) {
            return;
        }
        //dump("Preremove");
        foreach($args->getEntity()->getImages() as $key => $image) {
            //($image);
            $this->cacheManager->remove($this->uploaderHelper->asset($image, 'imageFile'));
        }*/
    }

    public function preUpdate(LifecycleEventArgs  $args)
    {
        
        $entity = $args->getObject();
        if (!$entity instanceof MotherboardImage){
            return;
        }
        //dump($entity);
        if ($entity->getImageFile() instanceof UploadedFile) {
            $this->cacheManager->remove($args->getEntityChangeSet()['file_name'][0]);
        }
        /*if (!$args->getEntity() instanceof Motherboard) {
            return;
        }
        ///dump("Preupdate");
        foreach($args->getEntity()->getImages() as $key => $image) {
            //dump($image->getImageFile());
            if($image->getImageFile() instanceof UploadedFile) {
                $this->cacheManager->remove($this->uploaderHelper->asset($image, 'imageFile'));
            }
        }*/
    }
}