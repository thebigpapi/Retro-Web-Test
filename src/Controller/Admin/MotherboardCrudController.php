<?php

namespace App\Controller\Admin;

use App\Entity\Motherboard;
use App\Form\Type\MotherboardAliasType;
use App\Form\Type\MotherboardIdRedirectionType;
use App\Form\Type\DramTypeType;
use App\Form\Type\MotherboardMaxRamType;
use App\Form\Type\CacheSizeType;
use App\Form\Type\PSUConnectorType;
use App\Form\Type\MotherboardIoPortType;
use App\Form\Type\MotherboardExpansionSlotType;
use App\Form\Type\KnownIssueType;
use App\Form\Type\ExpansionChipType;
use App\Form\Type\LargeFileMotherboardType;
use App\Form\Type\MotherboardBiosType;
use App\Form\Type\ManualType;
use App\Form\Type\MiscFileType;
use App\Form\Type\CpuSocketType;
use App\Form\Type\ProcessorPlatformTypeForm;
use App\Form\Type\ProcessorSpeedType;
use App\Form\Type\ProcessorType;
use App\Form\Type\CoprocessorType;
use App\Form\Type\MotherboardImageTypeForm;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MotherboardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Motherboard::class;
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('motherboardAliases')
            ->add('chipset')
            ->add('expansionChips')
            //->add('motherboardMaxRams')
            ->add('cacheSize')
            ->add('dramType')
            //->add('motherboardExpansionSlots')
            //->add('motherboardIoPorts')
            ->add('processorPlatformTypes')
            ->add('cpuSockets')
            ->add('cpuSpeed')
            ->add('formFactor')
            ->add('knownIssues')
            ->add('psuConnectors')
            ->add('dimensions')
            //->add(BooleanFilter::new('images'))
            ->add('lastEdited');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('info')
            ->onlyOnForms();
        // index items
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('getManufacturerShortNameIfExist','Manufacturer')
            ->hideOnForm();
        yield TextField::new('name')
            ->hideOnForm();
        yield BooleanField::new('getManuals','Manual?')
            ->renderAsSwitch(false)
            ->onlyOnIndex();
        yield BooleanField::new('getMotherboardBios','BIOS?')
            ->renderAsSwitch(false)
            ->onlyOnIndex();

        // show and indes
        yield DateField::new('lastEdited')
            ->hideOnForm();

        // editor items
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setColumns(4)
            ->onlyOnForms();
        yield TextField::new('name')
        ->setColumns(4)
            ->onlyOnForms();
        yield SlugField::new('slug')
        ->setTargetFieldName(['manufacturer', 'name'])
        ->setColumns(4)
            ->onlyOnForms();
        yield CollectionField::new('motherboardAliases', 'Alternative names')
            ->setEntryType(MotherboardAliasType::class)
            ->renderExpanded()
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('redirections', 'Redirections')
            ->setEntryType(MotherboardIdRedirectionType::class)
            ->renderExpanded()
            ->setColumns(6)
            ->onlyOnForms();
        yield FormField::addPanel('Misc')
            ->onlyOnForms();
        yield AssociationField::new('formFactor','Form Factor')
            ->setColumns(6)
            ->onlyOnForms();
        yield TextField::new('dimensions')
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('knownIssues', 'Known issues')
            ->setEntryType(KnownIssueType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CodeEditorField::new('note')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield FormField::addTab('Advanced Data')
            ->setIcon('database')
            ->onlyOnForms();
        yield FormField::addPanel('Memory')->onlyOnForms();
        yield CollectionField::new('motherboardMaxRams', 'Supported RAM size')
            ->setEntryType(MotherboardMaxRamType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('dramType', 'Supported RAM types')
            ->setEntryType(DramTypeType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('cacheSize', 'Cache')
            ->setEntryType(CacheSizeType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addPanel('Connections')
            ->onlyOnForms();
        yield CollectionField::new('motherboardIoPorts', 'I/O ports')
            ->setEntryType(MotherboardIoPortType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('motherboardExpansionSlots', 'Expansion slots')
            ->setEntryType(MotherboardExpansionSlotType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('psuConnectors', 'PSU connectors')
            ->setEntryType(PSUConnectorType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addPanel('Chips')
            ->onlyOnForms();
        yield AssociationField::new('chipset')
            ->onlyOnForms();
        yield CollectionField::new('expansionChips', 'Expansion chipset')
            ->setEntryType(ExpansionChipType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('CPU stuff')
            ->setIcon('microchip')
            ->onlyOnForms();
        yield CollectionField::new('cpuSockets', 'CPU sockets')
            ->setEntryType(CpuSocketType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('processorPlatformTypes', 'CPU families')
            ->setEntryType(ProcessorPlatformTypeForm::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('cpuSpeed', 'FSB speed')
            ->setEntryType(ProcessorSpeedType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('processors', 'CPUs')
            ->setEntryType(ProcessorType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('coprocessors', 'NPUs')
            ->setEntryType(CoprocessorType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            //->useEntryCrudForm(MotherboardImageCrudController::class)
            ->setEntryType(MotherboardImageTypeForm::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->setEntryType(LargeFileMotherboardType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('motherboardBios', 'BIOS images')
            ->setEntryType(MotherboardBiosType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('manuals', 'Documentation')
            ->setEntryType(ManualType::class)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('miscFiles', 'Misc files')
            ->setEntryType(MiscFileType::class)
            ->renderExpanded()
            ->onlyOnForms();

    }
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('duplicate', 'Clone')
        ->setIcon('fa fa-copy')
        ->linkToUrl(
            fn (Motherboard $entity) => $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::EDIT)
                ->setEntityId($entity->getId())
                ->set('duplicate', '1')
                ->generateUrl()
        );
        $savelist = Action::new('saveshow', 'Save and view board')
        ->setIcon('fa fa-save')
        ->linkToCrudAction(Action::SAVE_AND_RETURN);
        $view = Action::new('view', 'View')
            ->linkToCrudAction('viewBoard');
        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_EDIT, $savelist)
            ->add(Crud::PAGE_INDEX, $view)
            ->reorder(Crud::PAGE_EDIT, ['duplicate', Action::SAVE_AND_CONTINUE, 'saveshow', Action::SAVE_AND_RETURN])
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function edit(AdminContext $context)
    {
        if ($context->getRequest()->query->has('duplicate')) {
            $entity = $context->getEntity()->getInstance();
            /** @var Motherboard $cloned */
            $cloned = clone $entity;
            $cloned->setLastEdited(new \DateTime('now'));
            $context->getEntity()->setInstance($cloned);
        }

        return parent::edit($context);
    }

    public function viewBoard(AdminContext $context)
    {
        $bid = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('motherboard_show', array('id'=>$bid));
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
{
    $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

    if ('saveshow' === $submitButtonName) {
        $url = $this->container->get(AdminUrlGenerator::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($context->getEntity()->getPrimaryKeyValue())
            ->generateUrl();

        return $this->redirect($url);
    }

    return parent::getRedirectResponseAfterSave($context, $action);
}

}
