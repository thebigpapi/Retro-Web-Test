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
use App\Repository\LargeFileRepository;
use App\Repository\MediaTypeFlagRepository;
use App\Repository\OsFamilyRepository;
use App\Repository\OsFlagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class FileController extends AbstractController
{
    /**
     * Routing
     */

    #[Route('/admin/manage/files', name:'admin_manage_files')]
    public function manage(Request $request, TranslatorInterface $translator): Response
    {
        switch (htmlentities($request->query->get('entity') ?? '')) {
            case "largefile":
                return $this->manageLargefiles($request, $translator);
                break;
            case "osfamily":
                return $this->manageOsfamilies($request, $translator);
                break;
            case "osflag":
                return $this->manageOsflags($request, $translator);
                break;
            case "mediatype":
                return $this->manageMediatypes($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_files', array("entity" => "largefile")));
        }
    }

    #[Route('/admin/manage/files/largefiles/add', name:'new_largeFile_add')]
    public function largeFileAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->renderLargeFileForm($request, new LargeFile(), 'admin/edit/files/largeFile.html.twig', $entityManager);
    }

    #[Route('/admin/manage/files/largefiles/{id}/edit', name:'new_largeFile_edit', requirements:['id' => '\d+'])]
    public function largeFileEdit(Request $request, int $id, LargeFileRepository $largeFileRepository, EntityManagerInterface $entityManager): Response
    {
        return $this->renderLargeFileForm($request, $largeFileRepository->find($id), 'admin/edit/files/largeFile.html.twig', $entityManager);
    }

    #[Route('/admin/manage/files/osfamilies/add', name:'new_osFamily_add')]
    public function osFamilyAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->renderEntityForm(
            $request,
            new OsFamily(),
            OsFamilyForm::class,
            'admin/edit/files/osFamily.html.twig',
            'osfamily',
            $entityManager
        );
    }

    #[Route('/admin/manage/files/osfamilies/{id}/edit', name:'new_osFamily_edit', requirements:['id' => '\d+'])]
    public function osFamilyEdit(Request $request, int $id, OsFamilyRepository $osFamilyRepository, EntityManagerInterface $entityManager): Response
    {
        return $this->renderEntityForm($request, $osFamilyRepository->find($id), OsFamilyForm::class, 'admin/edit/files/osFamily.html.twig', 'osfamily', $entityManager);
    }

    #[Route('/admin/manage/files/osflags/add', name:'new_osFlag_add')]
    public function osFlagAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->renderEntityForm(
            $request,
            new OsFlag(),
            OsFlagForm::class,
            'admin/edit/files/osFlag.html.twig',
            'osflag',
            $entityManager
        );
    }

    #[Route('/admin/manage/files/osflags/{id}/edit', name:'new_osFlag_edit', requirements:['id' => '\d+'])]
    public function osFlagEdit(Request $request, int $id, OsFlagRepository $osFlagRepository, EntityManagerInterface $entityManager): Response
    {
        return $this->renderEntityForm($request, $osFlagRepository->find($id), OsFlagForm::class, 'admin/edit/files/osFlag.html.twig', 'osflag', $entityManager);
    }

    #[Route('/admin/manage/files/mediatypes/add', name:'new_mediaType_add')]
    public function mediaTypeAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->renderEntityForm(
            $request,
            new MediaTypeFlag(),
            MediaTypeFlagForm::class,
            'admin/edit/files/mediaTypeFlag.html.twig',
            'mediatype',
            $entityManager
        );
    }

    #[Route('/admin/manage/files/mediatypes/{id}/edit', name:'new_mediaType_edit', requirements:['id' => '\d+'])]
    public function mediaTypeEdit(Request $request, int $id, MediaTypeFlagRepository $mediaTypeFlagRepository, EntityManagerInterface $entityManager): Response
    {
        return $this->renderEntityForm(
            $request,
            $mediaTypeFlagRepository->find($id),
            MediaTypeFlagForm::class,
            'admin/edit/files/mediaTypeFlag.html.twig',
            'mediatype',
            $entityManager
        );
    }

    /**
     * Index pages
     */

    private function manageLargefiles(Request $request, TranslatorInterface $translator): Response
    {
        return $this->render('admin/manage/files/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\FileController::listLargefile",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("file"),
            "entityDisplayNamePlural" => $translator->trans("files"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageOsfamilies(Request $request, TranslatorInterface $translator): Response
    {
        return $this->render('admin/manage/files/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\FileController::listOsfamily",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("os family"),
            "entityDisplayNamePlural" => $translator->trans("os families"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageOsflags(Request $request, TranslatorInterface $translator): Response
    {
        return $this->render('admin/manage/files/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\FileController::listOsflag",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("os flag"),
            "entityDisplayNamePlural" => $translator->trans("os flags"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageMediatypes(Request $request, TranslatorInterface $translator): Response
    {
        return $this->render('admin/manage/files/manage.html.twig', [
            "search" => "",
            "criterias" => [],
            "controllerList" => "App\\Controller\\Admin\\FileController::listMediatype",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("media type"),
            "entityDisplayNamePlural" => $translator->trans("media types"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function listLargefile(Request $request, PaginatorInterface $paginator, array $criterias, LargeFileRepository $largeFileRepository): Response
    {
        $objects = $largeFileRepository->findBy($criterias, ['name' => 'asc']);

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

    public function listOsfamily(Request $request, PaginatorInterface $paginator, array $criterias, OsFamilyRepository $osFamilyRepository): Response
    {
        $objects = $osFamilyRepository->findBy($criterias, ['name' => 'asc']);

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

    public function listOsflag(Request $request, PaginatorInterface $paginator, array $criterias, OsFlagRepository $osFamilyRepository): Response
    {
        $objects = $osFamilyRepository->findBy($criterias, ['name' => 'asc']);

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

    public function listMediatype(Request $request, PaginatorInterface $paginator, array $criterias, MediaTypeFlagRepository $mediaTypeFlagRepository): Response
    {
        $objects = $mediaTypeFlagRepository->findBy($criterias, ['name' => 'asc']);

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
    private function renderEntityForm(Request $request, $entity, $class, $template, $entityName, EntityManagerInterface $entityManager): Response
    {
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

    private function renderLargeFileForm(Request $request, LargeFile $entity, $template, EntityManagerInterface $entityManager): Response
    {
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
