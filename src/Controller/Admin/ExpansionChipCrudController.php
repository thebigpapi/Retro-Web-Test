<?php

namespace App\Controller\Admin;

use App\Entity\ExpansionChip;
use App\EasyAdmin\TextJsonField;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\Filter\ChipImageFilter;
use App\Controller\Admin\Filter\ChipDocFilter;
use App\Controller\Admin\Filter\ChipDriverFilter;
use App\Controller\Admin\Type\Chip\AliasCrudType;
use App\Controller\Admin\Type\Chip\DocumentationCrudType;
use App\Controller\Admin\Type\Chip\ImageCrudType;
use App\Controller\Admin\Type\Chip\LargeFileCrudType;
use App\Controller\Admin\Type\ExpansionCard\BiosCrudType;
use App\Controller\Admin\Type\PciDeviceCrudType;
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Orx;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\CrudControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Factory\ControllerFactory;
use EasyCorp\Bundle\EasyAdminBundle\Factory\PaginatorFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ExpansionChipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpansionChip::class;
    }
    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if (Action::SAVE_AND_RETURN === $submitButtonName) {
            $entityId = $context->getEntity()->getInstance()->getId();
            return $this->redirectToRoute('expansion_chip_show', array('id'=>$entityId));
        }
        return parent::getRedirectResponseAfterSave($context, $action);
    }
    public function configureActions(Actions $actions): Actions
    {
        $view = Action::new('view', 'View')->linkToCrudAction('viewExpChip');
        $eview = Action::new('eview', 'View')->linkToCrudAction('viewExpChip')->setIcon('fa fa-magnifying-glass');
        $logs = Action::new('logs', 'Logs')->linkToCrudAction('viewLogs');
        $elogs= Action::new('elogs', 'Logs')->linkToCrudAction('viewLogs')->setIcon('fa fa-history');
        return $actions
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_INDEX, $logs)
            ->add(Crud::PAGE_EDIT, $elogs)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $eview)
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('expansion chip')
            ->setEntityLabelInPlural('<img class=ea-entity-icon src=/build/icons/chip.svg width=48 height=48>Expansion chips')
            ->overrideTemplate('crud/edit', 'admin/crud/edit.html.twig')
            ->overrideTemplate('crud/new', 'admin/crud/new.html.twig')
            ->setPaginatorPageSize(100)
            ->setDefaultSort(['lastEdited' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('manufacturer')
            ->add('name')
            ->add('partNumber')
            ->add(ChipImageFilter::new('images'))
            ->add(ChipDocFilter::new('documentations'))
            ->add(ChipDriverFilter::new('drivers'))
            ->add('chipAliases')
            ->add('pciDevs')
            ->add('type');
    }
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Basic Data')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('manufacturer','Manufacturer')
            ->setFormTypeOption('placeholder', 'Type to select a manufacturer ...')
            ->setColumns(4);
        yield TextField::new('partNumber', 'Part number')
            ->setColumns(4);
        yield TextField::new('name', 'Name')
            ->setColumns(4);
        yield TextField::new('type','Type')->onlyOnIndex();
        // index
        yield ArrayField::new('getPciDevsLimited', 'Device ID')
            ->hideOnForm();
        yield CollectionField::new('images','Images')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('documentations','Docs')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        yield CollectionField::new('drivers','Drivers')
            ->setCustomOption('byCount', true)
            ->onlyOnIndex();
        // editor
        yield AssociationField::new('type','Type')
            ->setFormTypeOption('placeholder', 'Type to select a type ...')
            ->setColumns(6)
            ->onlyOnForms();
        yield CollectionField::new('pciDevs', 'Device ID')
            ->useEntryCrudForm(PciDeviceCrudType::class)
            ->setColumns(4)
            ->renderExpanded()
            ->onlyOnForms();
        yield IntegerField::new('sort', 'Sort position')
            ->setFormTypeOption('required', false)
            ->setFormTypeOption('empty_data', '1')
            ->setColumns(2);
        yield CodeEditorField::new('description')
            ->setLanguage('markdown')
            ->onlyOnForms();
        yield CollectionField::new('chipAliases', 'Chip aliases')
            ->useEntryCrudForm(AliasCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield FormField::addTab('Specs')
            ->setIcon('fa fa-info')
            ->onlyOnForms();
        yield TextJsonField::new('miscSpecs', 'Misc specs')
            ->setColumns(12)
            ->onlyOnForms();
        yield FormField::addTab('Attachments')
            ->setIcon('fa fa-download')
            ->onlyOnForms();
        yield CollectionField::new('images', 'Images')
            ->useEntryCrudForm(ImageCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('documentations', 'Documentation')
            ->useEntryCrudForm(DocumentationCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('drivers', 'Drivers')
            ->useEntryCrudForm(LargeFileCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield CollectionField::new('expansionChipBios', 'Firmware')
            ->useEntryCrudForm(BiosCrudType::class)
            ->setFormTypeOption('error_bubbling', false)
            ->setColumns(6)
            ->renderExpanded()
            ->onlyOnForms();
        yield DateField::new('lastEdited', 'Last edit')
            ->hideOnForm();
    }
    public function viewExpChip(AdminContext $context)
    {
        $chipsetId = $context->getEntity()->getInstance()->getId();
        return $this->redirectToRoute('expansion_chip_show', array('id'=>$chipsetId));
    }
    public function viewLogs(AdminContext $context)
    {
        $entityId = $context->getEntity()->getInstance()->getId();
        $entity = str_replace("\\", "-",$context->getEntity()->getFqcn());
        return $this->redirectToRoute('dh_auditor_show_entity_history', array('id' => $entityId, 'entity' => $entity));
    }
        /**
     * @param ExpansionChip $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->updateLastEdited();
        parent::updateEntity($entityManager, $entityInstance);
    }
    public function autocomplete(AdminContext $context): JsonResponse
    {
        $queryBuilder = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), FieldCollection::new([]), FilterCollection::new());
        $autocompleteContext = $context->getRequest()->get(AssociationField::PARAM_AUTOCOMPLETE_CONTEXT);

        /** @var CrudControllerInterface $controller */
        $controller = $this->container->get(ControllerFactory::class)->getCrudControllerInstance($autocompleteContext[EA::CRUD_CONTROLLER_FQCN], Action::INDEX, $context->getRequest());
        /** @var FieldDto|null $field */
        $field = FieldCollection::new($controller->configureFields($autocompleteContext['originatingPage']))->getByProperty($autocompleteContext['propertyName']);
        /** @var \Closure|null $queryBuilderCallable */
        $queryBuilderCallable = $field?->getCustomOption(AssociationField::OPTION_QUERY_BUILDER_CALLABLE);

        if (null !== $queryBuilderCallable) {
            $queryBuilderCallable($queryBuilder);
        }

        $queryBuilder->leftJoin('entity.chipAliases', 'alias');
        $queryBuilder->leftJoin('entity.manufacturer', 'man');
        if($queryBuilder->getDQLPart('where') != null){
            $newParts = array();
            foreach($queryBuilder->getDQLPart('where')?->getParts() as $part){
                $arr = $part->getParts();
                $parameter = substr($arr[1], strpos($arr[1], ':query'));
                array_pop($arr);
                array_push($arr, "LOWER(alias.partNumber) LIKE " . $parameter);
                array_push($arr, "LOWER(man.name) LIKE " . $parameter);
                array_push($newParts, $arr);
            }
            $partsArray = new Andx();
            foreach($newParts as $newPart){
                $partsArray->add(new Orx($newPart));
            }
            $queryBuilder->add('where', $partsArray);
        }

        $paginator = $this->container->get(PaginatorFactory::class)->create($queryBuilder);
        return JsonResponse::fromJsonString($paginator->getResultsAsJson());
    }
}
