<?php

namespace App\Controller\Admin\Filter;

use App\Form\Type\Admin\MotherboardImageFilterType;
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
            ->setFormType(MotherboardImageFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
         if ('schema' === $filterDataDto->getValue()) {
            
            $queryBuilder
                ->join('entity.images', 'moboimage')
                ->andWhere('moboimage.motherboardImageType=2')
                ->andWhere('moboimage.motherboardImageType<>1');
            //dd($queryBuilder);
        }
    }
}