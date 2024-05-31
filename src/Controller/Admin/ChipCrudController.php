<?php

namespace App\Controller\Admin;

use App\Entity\Chip;
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Orx;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\ControllerFactory;
use EasyCorp\Bundle\EasyAdminBundle\Factory\PaginatorFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chip::class;
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

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
