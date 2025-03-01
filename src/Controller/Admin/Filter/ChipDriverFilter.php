<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\Admin\BoolFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class ChipDriverFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(BoolFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        if ('yes' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.drivers', 'chipdrv')
                ->andWhere('chipdrv.id is not null');
        }
        if ('no' === $filterDataDto->getValue()) {
            $queryBuilder
                ->leftjoin('entity.drivers', 'chipdrv')
                ->andWhere('chipdrv.id is null');
        }
    }
}