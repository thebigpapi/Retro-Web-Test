<?php
namespace App\Controller\Admin;

use App\Entity\LargeFile;
use App\Entity\MediaTypeFlag;
use App\Entity\OsFamily;
use App\Entity\OsFlag;
use App\Form\Admin\Edit\LargeFileForm;
use App\Form\Admin\Edit\MediaTypeFlagForm;
use App\Form\Admin\Edit\OsFamilyForm;
use App\Form\Admin\Edit\OsFlagForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class FileController extends AbstractController {

    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/files", name="admin_manage_files")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)        
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "largefile":
                return $this->manage_largefiles($request, $translator);
                break;
            case "osfamily":
                return $this->manage_osfamilies($request, $translator);
                break;
            case "osflag":
                return $this->manage_osflags($request, $translator);
                break;
            case "mediatype":
                return $this->manage_mediatypes($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_files', array("entity" => "largefile")));
        }
    }

    /**
     * @Route("/admin/manage/files/largefiles/add", name="new_largeFile_add")
     * @param Request $request
     */
    public function largeFileAdd(Request $request)        
    {
        return $this->renderLargeFileForm($request, new LargeFile(), 'admin/edit/files/largeFile.html.twig');
    }

    /**
     * @Route("/admin/manage/files/largefiles/{id}/edit", name="new_largeFile_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function largeFileEdit(Request $request, int $id)        
    {
        return $this->renderLargeFileForm($request, $this->getDoctrine()
        ->getRepository(LargeFile::class)
        ->find($id), 'admin/edit/files/largeFile.html.twig');
    }

    /**
     * @Route("/admin/manage/files/osfamilies/add", name="new_osFamily_add")
     * @param Request $request
     */
    public function osFamilyAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new OsFamily(), OsFamilyForm::class, 'admin/edit/files/osFamily.html.twig', 'osfamily');
    }

    /**
     * @Route("/admin/manage/files/osfamilies/{id}/edit", name="new_osFamily_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function osFamilyEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request, $this->getDoctrine()
        ->getRepository(OsFamily::class)
        ->find($id), OsFamilyForm::class, 'admin/edit/files/osFamily.html.twig', 'osfamily');
    }

    /**
     * @Route("/admin/manage/files/osflags/add", name="new_osFlag_add")
     * @param Request $request
     */
    public function osFlagAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new OsFlag(), OsFlagForm::class, 'admin/edit/files/osFlag.html.twig', 'osflag');
    }

    /**
     * @Route("/admin/manage/files/osflags/{id}/edit", name="new_osFlag_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function osFlagEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request, $this->getDoctrine()
        ->getRepository(OsFlag::class)
        ->find($id), OsFlagForm::class, 'admin/edit/files/osFlag.html.twig', 'osflag');
    }

    /**
     * @Route("/admin/manage/files/mediatypes/add", name="new_mediaType_add")
     * @param Request $request
     */
    public function mediaTypeAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new MediaTypeFlag(), MediaTypeFlagForm::class, 'admin/edit/files/mediaTypeFlag.html.twig', 'mediatype');
    }

    /**
     * @Route("/admin/manage/files/mediatypes/{id}/edit", name="new_mediaType_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function mediaTypeEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request, $this->getDoctrine()
        ->getRepository(MediaTypeFlag::class)
        ->find($id), MediaTypeFlagForm::class, 'admin/edit/files/mediaTypeFlag.html.twig', 'mediatype');
    }

    /**
     * Index pages
     */

    private function manage_largefiles(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/files/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\FileController::list_largefile",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("file"),
            "entityDisplayNamePlural" => $translator->trans("files"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_osfamilies(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/files/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\FileController::list_osfamily",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("os family"),
            "entityDisplayNamePlural" => $translator->trans("os families"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_osflags(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/files/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\FileController::list_osflag",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("os flag"),
            "entityDisplayNamePlural" => $translator->trans("os flags"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_mediatypes(Request $request, TranslatorInterface $translator)        
    {
        return $this->render('admin/manage/files/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\FileController::list_mediatype",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("media type"),
            "entityDisplayNamePlural" => $translator->trans("media types"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function list_largefile(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(LargeFile::class)
            ->findBy($criterias, ['name' => 'asc']);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/files/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function list_osfamily(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(OsFamily::class)
            ->findBy($criterias, ['name' => 'asc']);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/files/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function list_osflag(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(OsFlag::class)
            ->findBy($criterias, ['name' => 'asc']);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/files/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function list_mediatype(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(MediaTypeFlag::class)
            ->findBy($criterias, ['name' => 'asc']);

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/files/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
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

            return $this->redirect($this->generateUrl('admin_manage_files', array("entity" => $entityName)));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

    private function renderLargeFileForm(Request $request, LargeFile $entity, $template) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(LargeFileForm::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            foreach ($form['mediaTypeFlags']->getData() as $key => $val) {
                $val->setLargeFile($entity);
            }
            foreach ($form['osFlags']->getData() as $key => $val) {
                $val->setLargeFile($entity);
            }
            
            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('admin_manage_files', array("entity" => 'largefile')));
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }
    
}