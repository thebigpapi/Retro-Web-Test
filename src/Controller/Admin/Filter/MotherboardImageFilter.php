<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\Admin\SchemaPhotoImageFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class MotherboardImageFilter implements FilterInterface
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
                ->leftjoin('entity.images', 'moboimage')
                ->andWhere('moboimage.id is not null');
        }
        if ('schemaonly' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'moboimage')
                ->andWhere('moboimage.id is not null')
                ->andWhere('entity.id not in (select mot.id from App\Entity\Motherboard mot join mot.images mi where mi.motherboardImageType between 2 and 4)');
        }
        if ('schema' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'moboimage')
                ->andWhere('moboimage.id is not null')
                ->andWhere("moboimage.motherboardImageType in (1,5)");
        }
        if ('photoonly' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'moboimage')
                ->andWhere('moboimage.id is not null')
                ->andWhere('entity.id not in (select mot.id from App\Entity\Motherboard mot join mot.images mi where mi.motherboardImageType=1 or mi.motherboardImageType=5)');
        }
        if ('photo' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'moboimage')
                ->andWhere('moboimage.id is not null')
                ->andWhere("moboimage.motherboardImageType between 2 and 4");
        }
        if ('none' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'moboimage')
                ->andWhere('moboimage.id is null');
        }
    }
}