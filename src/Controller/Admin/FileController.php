<?php
namespace App\Controller\Admin;

use App\Entity\LargeFile;
use App\Form\Admin\Edit\LargeFileForm;
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
        return $this->renderEntityForm($request, new LargeFile(), LargeFileForm::class, 'admin/add_largeFile.html.twig', 'largefile');
    }

    /**
     * @Route("/admin/manage/files/largefiles/{id}/edit", name="new_largeFile_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function dramTypeEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request, $this->getDoctrine()
        ->getRepository(LargeFile::class)
        ->find($id), LargeFileForm::class, 'admin/add_largeFile.html.twig', 'largefile');
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
    
}