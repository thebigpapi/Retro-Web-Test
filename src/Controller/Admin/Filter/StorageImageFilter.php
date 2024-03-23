<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\Admin\BoolFilterType;
use App\Form\Type\Admin\SchemaPhotoImageFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class StorageImageFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(SchemaPhotoImageFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        if ('any' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.storageDeviceImages', 'storageimage')
                ->andWhere('storageimage.id is not null');
        }
        if ('schemaonly' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.storageDeviceImages', 'storageimage')
                ->andWhere('storageimage.id is not null')
                ->andWhere("entity.id not in (select sd.id from App\Entity\StorageDevice sd join sd.storageDeviceImages si where si.type <> '1')");
        }
        if ('schema' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.storageDeviceImages', 'storageimage')
                ->andWhere('storageimage.id is not null')
                ->andWhere("storageimage.type = '1'");
        }
        if ('photoonly' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.storageDeviceImages', 'storageimage')
                ->andWhere('storageimage.id is not null')
                ->andWhere("entity.id not in (select sd.id from App\Entity\StorageDevice sd join sd.storageDeviceImages si where si.type = '1')");
        }
        if ('photo' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.storageDeviceImages', 'storageimage')
                ->andWhere('storageimage.id is not null')
                ->andWhere("storageimage.type <> '1'");
        }
        if ('none' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.storageDeviceImages', 'storageimage')
                ->andWhere('storageimage.id is null');
        }
    }
}