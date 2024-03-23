<?php

namespace App\Controller\Admin\Type\Motherboard;

use App\Entity\MotherboardMemoryConnector;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MemoryConnectorCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MotherboardMemoryConnector::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('count')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Count:'])
            ->addCssClass('count-css')
            ->setColumns('col-4 col-sm-3 col-lg-4 col-xxl-3 nopadright');
        yield AssociationField::new('memoryConnector', 'Connector')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('placeholder', 'Type to select a connector ...')
            ->setColumns('col-8 col-sm-9 col-lg-8 col-xxl-9 nopadleft');
    }
}