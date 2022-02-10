<?php

namespace App\Controller\Admin;

use App\Entity\Chipset;
use App\Entity\ChipsetPart;
use App\Entity\Manufacturer;
use App\Form\Admin\Manage\ChipsetSearchType;
use App\Form\Admin\Edit\ChipsetForm;
use App\Form\Admin\Edit\ChipsetPartForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChipsetController extends AbstractController
{


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/chipsets", name="admin_manage_chipsets")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "chipset":
                return $this->manageChipsets($request, $translator);
                break;
            case "part":
                return $this->manageParts($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_chipsets', array("entity" => "chipset")));
        }
    }

    /**
     * @Route("/admin/manage/chipsets/chipsets/add", name="new_chipset_add")
     * @param Request $request
     */
    public function chipsetAdd(Request $request)
    {
        return $this->renderChipsetForm($request, new Chipset());
    }

    /**
     * @Route("/admin/manage/chipsets/chipsets/{id}/edit", name="new_chipset_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function chipsetEdit(Request $request, int $id)
    {
        return $this->renderChipsetForm(
            $request,
            $this->getDoctrine()
                ->getRepository(Chipset::class)
                ->find($id)
        );
    }

    /**
     * @Route("/admin/manage/chipsets/parts/add", name="new_chipset_part_add")
     * @param Request $request
     */
    public function chipsetPartAdd(Request $request)
    {
        return $this->renderChipsetPartForm($request, new ChipsetPart());
    }

    /**
     * @Route("/admin/manage/chipsets/parts/{id}/edit", name="new_chipset_part_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function chipsetPartEdit(Request $request, int $id)
    {
        return $this->renderChipsetPartForm(
            $request,
            $this->getDoctrine()
                ->getRepository(ChipsetPart::class)
                ->find($id)
        );
    }

    /**
     * Index pages
     */

    private function manageChipsets(Request $request, TranslatorInterface $translator)
    {
        $search = $this->createForm(ChipsetSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) {
                $getParams["manufacturer"] = $data['manufacturer']->getId();
            }
            $getParams["entity"] = "chipset";
            return $this->redirect($this->generateUrl('admin_manage_chipsets', $getParams));
        } else {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer'));
            if ($manufacturerId && intval($manufacturerId)) {
                $criterias["manufacturer"] = $manufacturerId;
            }
        }

        return $this->render('admin/manage/chipsets/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ChipsetController::listChipset",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("chipset"),
            "entityDisplayNamePlural" => $translator->trans("chipsets"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manageParts(Request $request, TranslatorInterface $translator)
    {
        $search = $this->createForm(ChipsetSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) {
                $getParams["manufacturer"] = $data['manufacturer']->getId();
            }
            $getParams["entity"] = "part";
            return $this->redirect($this->generateUrl('admin_manage_chipsets', $getParams));
        } else {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer'));
            if ($manufacturerId && intval($manufacturerId)) {
                $criterias["manufacturer"] = $manufacturerId;
            }
        }

        return $this->render('admin/manage/chipsets/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ChipsetController::listPart",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("chipset part"),
            "entityDisplayNamePlural" => $translator->trans("chipset parts"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function listChipset(
        EntityManagerInterface $em,
        Request $request,
        PaginatorInterface $paginator,
        array $criterias
    ) {
        $where = "";
        if (!empty($criterias) && array_key_exists("manufacturer", $criterias)) {
            $where = "WHERE m.id = :manufacturer";
        }

        $dql   = "SELECT c 
        FROM App:Chipset c 
        JOIN c.manufacturer m $where 
        ORDER BY m.name ASC, c.release_date ASC, c.part_no ASC";
        $query = $em->createQuery($dql);
        $query->setParameters($criterias);

        $paginatedObjects = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/chipsets/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function listPart(
        EntityManagerInterface $em,
        Request $request,
        PaginatorInterface $paginator,
        array $criterias
    ) {
        $where = "";
        if (!empty($criterias) && array_key_exists("manufacturer", $criterias)) {
            $where = "WHERE m.id = :manufacturer";
        }

        $dql = "SELECT cp 
        FROM App:ChipsetPart cp 
        JOIN cp.manufacturer m $where 
        ORDER BY m.name ASC, cp.partNumber ASC, cp.name ASC";
        $query = $em->createQuery($dql);
        $query->setParameters($criterias);

        $paginatedObjects = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/chipsets/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    /**
     * Forms
     */

    private function renderChipsetForm(Request $request, Chipset $chipset)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $chipsetManufacturers = $this->getDoctrine()
            ->getRepository(Manufacturer::class)
            ->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));

        $chipsetParts = $this->getDoctrine()
            ->getRepository(ChipsetPart::class)
            ->findAll(array(), array('name' => 'ASC', 'shortName' => 'ASC'));

        usort(
            $chipsetParts,
            function ($a, $b) {
                if ($a->getFullName() == $b->getFullName()) {
                    return 0;
                }
                return ($a->getFullName() < $b->getFullName()) ? -1 : 1;
            }
        );

        $form = $this->createForm(ChipsetForm::class, $chipset, [
            'chipsetManufacturers' => $chipsetManufacturers,
            'chipsetParts' => $chipsetParts,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipset = $form->getData();

            foreach ($form['biosCodes']->getData() as $key => $val) {
                $val->setChipset($chipset);
            }
            foreach ($form['drivers']->getData() as $key => $val) {
                $val->setChipset($chipset);
            }
            foreach ($form['documentations']->getData() as $key => $val) {
                $val->setChipset($chipset);
            }

            $entityManager->persist($chipset);
            $entityManager->flush();

            return $this->redirectToRoute('chipset_show', array('id' => $chipset->getId()));
        }
        return $this->render('admin/edit/chipsets/chipset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function renderChipsetPartForm(Request $request, ChipsetPart $chipsetPart)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(ChipsetPartForm::class, $chipsetPart);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipsetPart = $form->getData();

            foreach ($form['chip']['chipAliases']->getData() as $key => $val) {
                $val->setChip($chipsetPart);
            }
            foreach ($form['chip']['images']->getData() as $key => $val) {
                $val->setChip($chipsetPart);
            }
            foreach ($form['documentations']->getData() as $key => $val) {
                $val->setChip($chipsetPart);
            }

            $entityManager->persist($chipsetPart);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('admin_manage_chipsets', array("entity" => "part")));
        }
        return $this->render('admin/edit/chipsets/chipset_part.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
