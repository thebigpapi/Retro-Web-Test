<?php

namespace App\Controller\Admin\Type\Motherboard;

use App\Entity\MotherboardIdRedirection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IdRedirectionCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MotherboardIdRedirection::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('sourceType', 'Source type')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('choices',[
                'Slug' => 'uh19_slug',
                'TH99' => 'th99',
                'UH19' => 'uh19',
            ])
            ->setFormTypeOption('placeholder', false)
            ->renderAsNativeWidget()
            ->setColumns(4);
        yield TextField::new('source', 'Source')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Source:'])
            ->setColumns(8);
    }
}