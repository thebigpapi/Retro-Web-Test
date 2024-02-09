<?php

namespace App\Controller\Admin\Type\ExpansionCard;

use App\Entity\ExpansionCardIdRedirection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IdRedirectionCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCardIdRedirection::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('sourceType', 'Source type')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('choices',[
                'UH19' => 'uh19',
                'TH99' => 'th99',
                'Slug' => 'uh19_slug',
            ])
            ->setFormTypeOption('data', 'uh19_slug')
            ->setFormTypeOption('placeholder', false)
            ->renderAsNativeWidget()
            ->setColumns(4);
        yield TextField::new('source', 'Source')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Source:'])
            ->setColumns(8);
    }
}