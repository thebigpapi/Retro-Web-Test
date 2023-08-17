<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class UserCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('username', 'Username');
        yield TextField::new('password', 'Password')
            ->onlyOnForms()
            ->hideWhenUpdating();
        yield ArrayField::new('roles', 'Roles');

    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined();
    }
    public function configureActions(Actions $actions): Actions
    {
        //dd($this->getContext());
        $reset = Action::new('reset', 'Reset', 'fa fa-reset')
            //->linkToUrl($this->generateUrl('admin_reset_pass', array('id' => $this->getContext())))
            ->linkToCrudAction('resetPass');
            //->askConfirmation('Are you very very sure? This will destroy the world!');
        return $actions
            ->add(Crud::PAGE_INDEX, $reset)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_ADMIN');
    }
    public function resetPass(AdminContext $context)
    {
        $uid = $context->getEntity()->getInstance()->getId();
        $url = $this->adminUrlGenerator
            ->setRoute('admin_reset_pass', array('id'=>$uid))
            ->generateUrl();
        return $this->redirect($url);
    }
}
