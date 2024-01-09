<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionCard;
use App\Form\Type\ExpansionCardAliasType;
use App\Form\Type\ExpansionCardBiosType;
use App\Form\Type\LargeFileExpansionCardType;
use App\Form\Type\ExpansionCardDocumentationType;
use App\Form\Type\ExpansionCardImageType;
use App\Form\Type\ExpansionChipType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\Filter\ChipImageFilter;
use App\Controller\Admin\Filter\ChipDocFilter;
use App\Controller\Admin\Filter\ChipDriverFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ExpansionCardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionCard::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('expansioncard_show', array('id'=>$entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $view = Action::new('view', 'View')->linkToCrudAction('viewExpCard');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewExpCard')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('expansion card')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/chip.svg width=48 height=48>Expansion cards')
            ->setPaginatorPageSize(100);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            /*->add(ChipImageFilter::new('images'))
            ->add(ChipDocFilter::new('documentations'))
            ->add(ChipDriverFilter::new('drivers'))*/
            //->add('chipAliases')
            //->add('pciDevs')
            ->add('type');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('getManufacturer','Manufacturer')
            ->hideOnForm();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('placeholder', 'Type to select a manufacturer ...')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('name', 'Name')
            ->setColumns(4);
        yield ArrayField::new('type','Type')->onlyOnIndex();
        // index
        yield BooleanField::new('isExpansionCardImage','Images')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('isExpansionCardBios','BIOS')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDocumentations','Docs')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getDrivers','Drivers')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        // editor
        yield AssociationField::new('type','Type')
            ->setFormTypeOption('placeholder', 'Type to select a type ...')
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('expansionChips', 'Expansion chips')
            ->setEntryType(ExpansionChipType::class)
            ->renderExpanded()
            ->setColumns('col-sm-12 col-lg-8 col-xxl-6')
            ->onlyOnForms();
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield CollectionField::new('expansionCardAliases', 'Alternative names')
            ->setEntryType(ExpansionCardAliasType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('BIOS images')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('expansionCardBios', 'BIOS')
            ->setEntryType(ExpansionCardBiosType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Other attachments')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->setEntryType(ExpansionCardImageType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->setEntryType(ExpansionCardDocumentationType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileExpansionCardType::class)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
    }
    public function viewExpCard(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('expansioncard_show', array('id'=>$entityId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
        /**
     * @param ExpansionCard $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
}
