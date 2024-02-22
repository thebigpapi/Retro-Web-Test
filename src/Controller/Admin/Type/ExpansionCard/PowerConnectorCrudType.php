<?php

namespace App\Controller\Admin\Type\ExpansionCard;

use App\Entity\ExpansionCardPowerConnector;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PowerConnectorCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCardPowerConnector::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('count')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Count:'])
            ->addCssClass('count-css')
            ->setColumns('col-4 col-sm-3 col-lg-4 col-xxl-3 nopadright');
        yield AssociationField::new('powerConnector', 'Preset')
            ->autocomplete()
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Connector:'])
            ->setColumns('col-8 col-sm-9 col-lg-8 col-xxl-9 nopadleft');
    }
}