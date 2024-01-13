<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\Admin\SchemaPhotoImageFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class ExpansionCardImageFilter implements FilterInterface
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
                ->leftjoin('entity.images', 'cardimage')
                ->andWhere('cardimage.id is not null');
        }
        if ('schemaonly' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'cardimage')
                ->andWhere("cardimage.id is not null ")
                ->andWhere("entity.id not in (select ec.id from App\Entity\ExpansionCard ec join ec.images ei where ei.type in ('2', '3', '4'))");
        }
        if ('schema' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'cardimage')
                ->andWhere("cardimage.id is not null ")
                ->andWhere("cardimage.type in ('1','5')");
        }
        if ('photoonly' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'cardimage')
                ->andWhere("cardimage.id is not null")
                ->andWhere("entity.id not in (select ec.id from App\Entity\ExpansionCard ec join ec.images ei where ei.type in ('1', '5'))");
        }
        if ('photo' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'cardimage')
                ->andWhere("cardimage.id is not null")
                ->andWhere("cardimage.type in ('2','3','4')");
        }
        if ('none' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.images', 'cardimage')
                ->andWhere('cardimage.id is null');
        }
    }
}