<?php

namespace App\Controller\Admin\Type;

use App\EasyAdmin\HexField;
use App\Entity\PciDeviceId;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PciDeviceCrudType extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PciDeviceId::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield HexField::new('dev')
            ->setFormTypeOption('label',false)
            ->setFormTypeOption('attr',['placeholder' => 'Device ID:'])
            ->setColumns(12);
    }

    /*public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setNumberFormat('hex');
    }*/

    public function new(AdminContext $context)
    {
        dd($context->getEntity());
    }

    public function edit(AdminContext $context)
    {
        dd($context->getEntity());
    }

    public function delete(AdminContext $context)
    {
        dd($context->getEntity());
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        dd($entityInstance);
    }


}