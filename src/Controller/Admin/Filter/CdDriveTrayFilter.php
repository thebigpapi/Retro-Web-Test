<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\Admin\CdDriveTrayFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;

class CdDriveTrayFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(CdDriveTrayFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        if ('Tray' === $filterDataDto->getValue()) {
            $queryBuilder
                ->andWhere("entity.trayType LIKE '%Tray%'");
        }
        if ('Caddy' === $filterDataDto->getValue()) {
            $queryBuilder
                ->andWhere("entity.trayType LIKE '%Caddy%'");
        }
        if ('Slot' === $filterDataDto->getValue()) {
            $queryBuilder
                ->andWhere("entity.trayType LIKE '%Slot%'");
        }
    }
}