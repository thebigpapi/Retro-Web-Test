<?php
namespace App\EasyAdmin;

use App\Form\Type\Admin\HexType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class HexField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(HexType::class)
            ->setDefaultColumns('col-md-4 col-xxl-3');
    }
}
