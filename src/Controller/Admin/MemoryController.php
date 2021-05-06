<?php
namespace App\Controller\Admin;

use App\Entity\CacheSize;
use App\Entity\DramType;
use App\Entity\MaxRam;
use App\Form\EditCacheSize;
use App\Form\EditDramType;
use App\Form\EditMaxRam;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class MemoryController extends AbstractController {


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/memories", name="admin_manage_memories")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)        
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "ramtype":
                return $this->manage_ram_types($request, $translator);
                break;
            case "ramsize":
                return $this->manage_ram_sizes($request, $translator);
                break;
            case "cachesize":
                return $this->manage_cache_sizes($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_memories', array("entity" => "ramtype")));
        }
    }

    /**
     * @Route("/admin/manage/memories/ramtypes/add", name="new_dramType_add")
     * @param Request $request
     */
    public function dramTypeAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new DramType(), EditDramType::class, 'admin/add_dramType.html.twig', 'ramtype');
    }

    /**
     * @Route("/admin/manage/memories/ramtypes/{id}/edit", name="new_dramType_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function dramTypeEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request, $this->getDoctrine()
        ->getRepository(DramType::class)
        ->find($id), EditDramType::class, 'admin/add_dramType.html.twig', 'ramtype');
    }

    /**
     * @Route("/admin/manage/memories/ramsizes/add", name="new_ramSize_add")
     * @param Request $request
     */
    public function ramSizeAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new MaxRam(), EditMaxRam::class, 'admin/add_maxRam.html.twig', 'ramsize');
    }

    /**
     * @Route("/admin/manage/memories/ramsizes/{id}/edit", name="new_ramSize_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function ramSizeEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
        ->getRepository(MaxRam::class)
        ->find($id)
        , EditMaxRam::class, 'admin/add_maxRam.html.twig', 'ramsize');
    }

    /**
     * @Route("/admin/manage/memories/cachesizes/add", name="new_cacheSize_add")
     * @param Request $request
     */
    public function cacheSizeAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new CacheSize(), EditCacheSize::class, 'admin/add_cacheSize.html.twig', 'cachesize');
    }

    /**
     * @Route("/admin/manage/memories/cachesizes/{id}/edit", name="new_cacheSize_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function cacheSizeEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
        ->getRepository(CacheSize::class)
        ->find($id)
        , EditCacheSize::class, 'admin/add_cacheSize.html.twig', 'cachesize');
    }

    /**
     * Index pages
     */

    private function manage_ram_types(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/memories/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MemoryController::list_ramtype",
            "entityName" => "ramtype",
            "entityDisplayName" => $translator->trans("memory type"),
            "entityDisplayNamePlural" => $translator->trans("memory types"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_ram_sizes(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/memories/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MemoryController::list_memorysize",
            "entityName" => "ramsize",
            "entityDisplayName" => $translator->trans("memory size"),
            "entityDisplayNamePlural" => $translator->trans("memory sizes"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_cache_sizes(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/memories/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\MemoryController::list_cachesize",
            "entityName" => "cachesize",
            "entityDisplayName" => $translator->trans("cache size"),
            "entityDisplayNamePlural" => $translator->trans("cache sizes"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function list_ramtype(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(DramType::class)
            ->findBy($criterias);
        

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/memories/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => "ramtype",
        ]);
    }

    public function list_memorysize(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(MaxRam::class)
            ->findBy($criterias, array("value" => "asc"));
        

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/memories/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => "ramsize",
        ]);
    }

    public function list_cachesize(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(CacheSize::class)
            ->findBy($criterias, array("value" => "asc"));
        

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/memories/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => "cachesize",
        ]);
    }


    /**
     * Forms
     */
    private function renderEntityForm(Request $request, $entity, $class, $template, $entityName) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm($class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            
            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('admin_manage_memories', array("entity" => $entityName)));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

}