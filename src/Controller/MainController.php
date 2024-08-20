<?php

namespace App\Controller;

use App\Repository\CdDriveRepository;
use App\Repository\ChipRepository;
use App\Repository\FloppyDriveRepository;
use App\Repository\HardDriveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MotherboardRepository;
use App\Repository\MotherboardBiosRepository;
use App\Repository\ChipsetRepository;
use App\Repository\LargeFileRepository;
use App\Repository\ExpansionCardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class MainController extends AbstractController
{
    #[Route('/', name:'app_homepage')]
    public function index(
        MotherboardRepository $motherboardRepository,
        MotherboardBiosRepository $motherboardBiosRepository,
        ChipsetRepository $chipsetRepository,
        LargeFileRepository $largeFileRepository,
        HardDriveRepository $hddRepository,
        CdDriveRepository $cddRepository,
        FloppyDriveRepository $fddRepository,
        ChipRepository $chipRepository,
        ExpansionCardRepository $expansionCardRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('type', 'type');
        $rsm->addScalarResult('subtype', 'subtype');
        $rsm->addScalarResult('manufacturer_name', 'manufacturer_name');
        $rsm->addScalarResult('entity_name', 'entity_name');
        $rsm->addScalarResult('part_number', 'part_number');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('last_edited', 'last_edited');
        $rsm->addScalarResult('file_name', 'file_name');
        $rsm->addScalarResult('image_type', 'image_type');

        $query = $entityManager->createNativeQuery(
            $this->getBigChungusSql('', 'DESC LIMIT :maxResult', 'ORDER BY last_edited'), $rsm);
        $query->setParameter('maxResult', 20);
        $latestEntities = $query->getResult();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'latestEntities' => $latestEntities,
            'moboCount' => $motherboardRepository->getCount(),
            'chipCount' => $chipsetRepository->getCount(),
            'expchipCount' => $chipRepository->getCount(),
            'expcardCount' => $expansionCardRepository->getCount(),
            'biosCount' => $motherboardBiosRepository->getCount(),
            'driverCount' => $largeFileRepository->getCount(),
            'hddCount' => $hddRepository->getCount(),
            'cddCount' => $cddRepository->getCount(),
            'fddCount' => $fddRepository->getCount(),
        ]);
    }

    #[Route('/info', name:'app_info')]
    public function info(): Response
    {
        return $this->render('main/info.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/info/credits', name:'app_credits')]
    public function credits(): Response
    {
        return $this->render('main/credits.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/info/contributions', name:'app_contributions')]
    public function contrib(): Response
    {
        return $this->render('main/contrib.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/info/legal', name:'app_legal')]
    public function legal(): Response
    {
        return $this->render('main/legal.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/support', name:'app_support')]
    public function support(): Response
    {
        return $this->render('main/support.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/search', name:'app_generic_search')]
    public function genericSearch(#[MapQueryParameter] string $query, Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager) :Response
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('type', 'type');
        $rsm->addScalarResult('subtype', 'subtype');
        $rsm->addScalarResult('manufacturer_name', 'manufacturer_name');
        $rsm->addScalarResult('entity_name', 'entity_name');
        $rsm->addScalarResult('part_number', 'part_number');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('last_edited', 'last_edited');
        $rsm->addScalarResult('file_name', 'file_name');
        $rsm->addScalarResult('image_type', 'image_type');

        $sqlQuery = $entityManager->createNativeQuery(
            $this->getBigChungusSql(" WHERE name ILIKE :query ", '', 'ORDER BY name'), $rsm);

            //dd($query->getSQL());
        $sqlQuery->setParameter(":query", '%' . $query . '%');
        $entities = $paginator->paginate($sqlQuery->getResult(), $request->query->getInt('page', 1), 20);
        return $this->render('main/entitysearch.html.twig', [
            'entities' => $entities,
            'query' => $query
        ]);
    }

    private function getBigChungusSql(string $filter, string $limit, string $orderBy): string {
        return "SELECT * FROM (SELECT entities.id, entities.type, man.name as manufacturer_name, entities.name as entity_name, entities.part_number as part_number, COALESCE(man.name, 'unidentified') || ' ' || COALESCE(entities.name, 'unidentified') || ' ' || COALESCE(entities.part_number, '') as name, last_edited, file_name, image_type FROM (
                SELECT mot.id, 'motherboard' as type, 'motherboard' as subtype, manufacturer_id, name, NULL as part_number, last_edited FROM motherboard mot
                UNION
                SELECT c.id, 'chip' as type, 'chip' as subtype, manufacturer_id, name, part_number, last_edited FROM chip c
                UNION
                SELECT ec.id, 'expansioncard' as type, 'expansioncard' as subtype, manufacturer_id, name, NULL as part_number, last_edited FROM expansion_card ec
                UNION
                SELECT sd.id,'storage' as type, dtype as subtype, manufacturer_id, name, part_number, last_edited FROM storage_device sd
                UNION
                SELECT lf.id, 'driver' as type, 'driver' as subtype, NULL, name, NULL as part_number, updated_at as last_edited FROM large_file lf $orderBy $limit
            ) as entities
            LEFT JOIN manufacturer man ON man.id = entities.manufacturer_id
            LEFT JOIN (SELECT * FROM(
                SELECT motherboard_id as id, file_name, REPLACE(REPLACE(CAST(motherboard_image_type_id AS VARCHAR), '1','schema'), '2','photo') as image_type, 'motherboard' as type, row_number() over (partition by motherboard_id order by case when motherboard_image_type_id <> 1 THEN 1 ELSE 2 END, updated_at DESC) as rn FROM motherboard_image WHERE motherboard_image_type_id BETWEEN 1 AND 2
                UNION
                SELECT chip_id as id, file_name, 'photo' as image_type, 'chip' as type, row_number() over (partition by chip_id order by updated_at) as rn FROM chip_image
                UNION
                SELECT expansion_card_id as id, file_name, REPLACE(REPLACE(type, '1','schema'), '2','photo') as image_type, 'expansioncard' as type, row_number() over (partition by expansion_card_id order by case when type <> '1' THEN 1 ELSE 2 END, updated_at DESC) as rn FROM expansion_card_image WHERE CAST(expansion_card_image.type AS INTEGER) BETWEEN 1 AND 2
                UNION 
                SELECT storage_device_id as id, file_name, REPLACE(REPLACE(type, '1','schema'), '2','photo') as image_type, 'storage' as type, row_number() over (partition by storage_device_id order by case when type <> '1' THEN 1 ELSE 2 END, updated_at DESC) FROM storage_device_image WHERE CAST(storage_device_image.type AS INTEGER) BETWEEN 1 AND 2
            ) as images_all WHERE rn=1
            ) as images ON entities.id = images.id AND entities.type=images.type
            ) as result
            $filter
            $orderBy
            ;";
    }
}
