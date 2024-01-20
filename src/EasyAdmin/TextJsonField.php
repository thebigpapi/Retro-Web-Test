<?php
namespace App\EasyAdmin;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use App\Form\Type\Admin\JsonType;
class TextJsonField implements FieldInterface
{
    use FieldTrait;
    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(JsonType::class)
            ->setDefaultColumns('col-md-4 col-xxl-3');
    }
}