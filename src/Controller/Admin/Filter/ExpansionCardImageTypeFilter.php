<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\Admin\ExpansionCardImageFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class ExpansionCardImageTypeFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(ExpansionCardImageFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        if ('1' === $filterDataDto->getValue()) {
            $queryBuilder
                ->andWhere("entity.type = '1'");
        }
        if ('2' === $filterDataDto->getValue()) {
            $queryBuilder
                ->andWhere("entity.type = '2'");
        }
        if ('3' === $filterDataDto->getValue()) {
            $queryBuilder
                ->andWhere("entity.type = '3'");
        }
        if ('4' === $filterDataDto->getValue()) {
            $queryBuilder
                ->andWhere("entity.type = '4'");
        }
        if ('5' === $filterDataDto->getValue()) {
            $queryBuilder
                ->andWhere("entity.type = '5'");
        }
    }
}