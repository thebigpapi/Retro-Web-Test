<?php
namespace App\Controller\Admin;

use App\Entity\AudioChipset;
use App\Entity\Manufacturer;
use App\Entity\VideoChipset;
use App\Form\Admin\Manage\AudioChipSearchType;
use App\Form\Admin\Manage\VideoChipSearchType;
use App\Form\EditAudioChipset;
use App\Form\EditVideoChipset;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExpansionChipsetController extends AbstractController {


    /**
     * Routing
     */

    /**
     * @Route("/admin/manage/expansionchipsets", name="admin_manage_expansion_chipsets")
     * @param Request $request
     */
    public function manage(Request $request, TranslatorInterface $translator)        
    {
        switch (htmlentities($request->query->get('entity'))) {
            case "audiochip":
                return $this->manage_audio_chips($request, $translator);
                break;
            case "videochip":
                return $this->manage_video_chips($request, $translator);
                break;
            default:
                return $this->redirect($this->generateUrl('admin_manage_expansion_chipsets', array("entity" => "audiochip")));
        }
    }

    /**
     * @Route("/admin/manage/expansionchipsets/audiochips/add", name="new_audioChipset_add")
     * @param Request $request
     */
    public function audioChipsetAdd(Request $request)        
    {
        return $this->renderAudioChipsetForm($request, new AudioChipset());
    }

    /**
     * @Route("/admin/manage/expansionchipsets/audiochips/{id}/edit", name="new_audioChipset_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function audioChipsetEdit(Request $request, int $id)        
    {
        return $this->renderAudioChipsetForm($request,$this->getDoctrine()
            ->getRepository(AudioChipset::class)
            ->find($id)
        );
    }

    /**
     * @Route("/admin/manage/expansionchipsets/videochips/add", name="new_videoChipset_add")
     * @param Request $request
     */
    public function videoChipsetAdd(Request $request)        
    {
        return $this->renderVideoChipsetForm($request, new VideoChipset());
    }

    /**
     * @Route("/admin/manage/expansionchipsets/videochips/{id}/edit", name="new_videoChipset_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function videoChipsetEdit(Request $request, int $id)        
    {
        return $this->renderVideoChipsetForm($request,$this->getDoctrine()
            ->getRepository(VideoChipset::class)
            ->find($id)
        );
    }

    /**
     * Index pages
     */

    private function manage_audio_chips(Request $request, TranslatorInterface $translator)        
    {
        $search = $this->createForm(AudioChipSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) $getParams["manufacturer"] = $data['manufacturer']->getId();
            $getParams["entity"] = "audiochip";
            return $this->redirect($this->generateUrl('admin_manage_expansion_chipsets', $getParams));
        }
        else
        {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer'));
            if ($manufacturerId && intval($manufacturerId))
                $criterias["manufacturer"] = $manufacturerId;
        }

        return $this->render('admin/manage/expansion_chipsets/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ExpansionChipsetController::list_audio_chip",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("audio chip"),
            "entityDisplayNamePlural" => $translator->trans("audio chips"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    private function manage_video_chips(Request $request, TranslatorInterface $translator)        
    {
        $search = $this->createForm(VideoChipSearchType::class);

        $getParams = array();
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $data = $search->getData();
            if ($data['manufacturer']) $getParams["manufacturer"] = $data['manufacturer']->getId();
            $getParams["entity"] = "videochip";
            return $this->redirect($this->generateUrl('admin_manage_expansion_chipsets', $getParams));
        }
        else
        {
            $criterias = array();
            $manufacturerId = htmlentities($request->query->get('manufacturer'));
            if ($manufacturerId && intval($manufacturerId))
                $criterias["manufacturer"] = $manufacturerId;
        }

        return $this->render('admin/manage/expansion_chipsets/manage.html.twig', [
            "search" => $search->createView(),
            "criterias" => $criterias,
            "controllerList" => "App\\Controller\\Admin\\ExpansionChipsetController::list_video_chip",
            "entityName" => $request->query->get('entity'),
            "entityDisplayName" => $translator->trans("video chip"),
            "entityDisplayNamePlural" => $translator->trans("video chips"),
            "page" => $request->query->getInt('page', 1),
        ]);
    }

    public function list_audio_chip(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(AudioChipset::class)
            ->findBy($criterias);

        usort($objects, function ($a, $b)
        {
            if ($a->getManufacturer()->getShortNameIfExist() == $b->getManufacturer()->getShortNameIfExist()) {
                if ($a->getName() == $b->getName()) {
                    return 0;
                }
                return ($a->getName() < $b->getName()) ? -1 : 1;
            }
            return ($a->getManufacturer()->getShortNameIfExist() < $b->getManufacturer()->getShortNameIfExist()) ? -1 : 1;
        }
        );

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/expansion_chipsets/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    public function list_video_chip(Request $request, PaginatorInterface $paginator, array $criterias)        
    {
        $objects = $this->getDoctrine()
            ->getRepository(VideoChipset::class)
            ->findBy($criterias);

        usort($objects, function ($a, $b)
        {
            if ($a->getManufacturer()->getShortNameIfExist() == $b->getManufacturer()->getShortNameIfExist()) {
                if ($a->getName() == $b->getName()) {
                    return 0;
                }
                return ($a->getName() < $b->getName()) ? -1 : 1;
            }
            return ($a->getManufacturer()->getShortNameIfExist() < $b->getManufacturer()->getShortNameIfExist()) ? -1 : 1;
        }
        );

        $paginatedObjects = $paginator->paginate(
            $objects,
            $request->query->getInt('page', 1),
            $this->getParameter('app.pagination.max')
        );

        return $this->render('admin/manage/expansion_chipsets/list.html.twig', [
            "objectList" => $paginatedObjects,
            "entityName" => $request->query->get('entity'),
        ]);
    }

    /**
     * Forms
     */

    private function renderAudioChipsetForm(Request $request, $chipset) {
        $entityManager = $this->getDoctrine()->getManager();
        $chipsetManufacturers = $this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));
        
        $form = $this->createForm(EditAudioChipset::class, $chipset, [
            'chipsetManufacturers' => $chipsetManufacturers,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipset = $form->getData();
            
            $entityManager->persist($chipset);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('admin_manage_expansion_chipsets', array("entity" => "audiochip")));
        }
        return $this->render('admin/add_audioChipset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function renderVideoChipsetForm(Request $request, $chipset) {
        $entityManager = $this->getDoctrine()->getManager();
        $chipsetManufacturers = $this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));
        
        $form = $this->createForm(EditVideoChipset::class, $chipset, [
            'chipsetManufacturers' => $chipsetManufacturers,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipset = $form->getData();
            
            $entityManager->persist($chipset);
            $entityManager->flush();
            
            return $this->redirect($this->generateUrl('admin_manage_expansion_chipsets', array("entity" => "videochip")));
        }
        return $this->render('admin/add_videoChipset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}