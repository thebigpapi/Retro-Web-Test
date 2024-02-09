<?php

namespace App\Controller\Admin\Type\ExpansionCard;

use App\Entity\ExpansionCardMemoryConnector;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MemoryConnectorCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCardMemoryConnector::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('count')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Count:'])
            ->addCssClass('count-css')
            ->setColumns('col-4 col-sm-3 col-lg-3 col-xxl-2 nopadright');
        yield AssociationField::new('memoryConnector', 'Connector')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('placeholder', 'Type to select a connector ...')
            ->setColumns('col-8 col-sm-9 col-lg-9 col-xxl-10 nopadleft');
    }
}