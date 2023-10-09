<?php

namespace App\Controller\Admin;

use App\Entity\InstructionSet;
use App\Form\Type\InstructionSetType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InstructionSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InstructionSet::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('instruction set')
            ->setEntityLabelInPlural('Instruction sets')
            ->setPaginatorPageSize(100);
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name', 'Name');
        yield ArrayField::new('getCompatibleWith', 'Compatible with instruction sets')
            ->onlyOnIndex();
        yield CollectionField::new('compatibleWith', 'Compatible with instruction sets')
            ->setEntryType(InstructionSetType::class)
            ->renderExpanded()
            ->onlyOnForms();
    }
}
