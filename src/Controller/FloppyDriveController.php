<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Entity\StorageDeviceIdRedirection;
use App\Form\FloppyDrive\Search;
use App\Repository\FloppyDriveRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\StorageDeviceIdRedirectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FloppyDriveController extends AbstractController
{
    #[Route(path: '/floppydrives/{id}', name: 'floppy_drive_show', requirements: ['id' => '\d+'])]
    public function floppyDriveShow(int $id, FloppyDriveRepository $floppyDriveRepository, StorageDeviceIdRedirectionRepository $storageDeviceIdRedirectionRepository)
    {
        $fdd = $floppyDriveRepository->find($id);
        if (!$fdd) {
            $idRedirection = $storageDeviceIdRedirectionRepository->findRedirection($id, 'trw');

            if (!$idRedirection) {
                throw $this->createNotFoundException(
                    'No floppy drive found for id ' . $id
                );
            }
            return $this->redirect($this->generateUrl('floppy_drive_show', array("id" => $idRedirection)));
        }
        return $this->render('floppydrive/show.html.twig', [
            'floppydrive' => $fdd,
            'controller_name' => 'FloppyDriveController',
        ]);
    }

    #[Route(path: '/floppydrives/', name: 'fddsearch', methods: ['GET'])]
    public function searchResultFdd(Request $request, PaginatorInterface $paginator, FloppyDriveRepository $fddRepository, ManufacturerRepository $manufacturerRepository)
    {
        $latestFdds = $fddRepository->findLatest(8);
        $form = $this->_searchFormHandlerFdd($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('fddsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaFdd($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('floppydrive/search.html.twig', [
                'form' => $form->createView(),
                'latestFdds' => $latestFdds,
            ]);
        }

        $data = $fddRepository->findByFdd($criterias);
        $fdds = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('floppydrive/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'FloppyDriveController',
            'fdds' => $fdds,
        ]);
    }
    #[Route('/floppydrives/live', name: 'fddlivewrapper')]
    public function liveSearchFdd(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerFdd($request, $manufacturerRepository);
        return $this->redirect($this->generateUrl('fddlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/floppydrives/results', name: 'fddlivesearch')]
    public function liveResultsFdd(Request $request, PaginatorInterface $paginator, FloppyDriveRepository $fddRepository): Response
    {
        $criterias = $this->getCriteriaFdd($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $fddRepository->findByFdd($criterias);
        $fdds = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/floppydrives/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('floppydrive/result.html.twig', [
            'controller_name' => 'FloppyDriveController',
            'fdds' => $fdds,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }

    #[Route('/dashboard/floppy-drive-delete/{id}', name: 'floppy_drive_delete', requirements: ["id" => "\d+"])]
    public function delete(
        Request $request,
        int $id,
        FloppyDriveRepository $floppyDriveRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $fdd = $floppyDriveRepository->find($id);

        if (!$fdd) {
            throw $this->createNotFoundException(
                'No $fdd found for id ' . $id
            );
        }
        //$slug = $fdd->getSlug();

        $form = $this->createFormBuilder()
            ->add('No', SubmitType::class)
            ->add('Yes', SubmitType::class)
            ->add('Redirection', NumberType::class, [
                'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var ClickableInterface
             */
            $noButton = $form->get('No');
            /**
             * @var ClickableInterface
             */
            $yesButton = $form->get('Yes');
            if ($noButton->isClicked()) {
                return $this->redirect($this->generateUrl('floppy_drive_show', array("id" => $id)));
            }
            if ($yesButton->isClicked()) {
                //If user selected a fdd where the current id will redirect to
                if ($form->get('Redirection') && !is_null($form->get('Redirection')->getData())) {
                    $idRedirection = $form->get('Redirection')->getData();
                    $destinationFdd = $floppyDriveRepository->find($idRedirection);


                    if ($destinationFdd) {
                        //Creating new redirection
                        $redirection = new StorageDeviceIdRedirection();
                        $redirection->setSource($id);
                        $redirection->setSourceType('trw');
                        $redirection->setDestination($destinationFdd);

                        /*$slugRedirection = new StorageDeviceIdRedirection();
                        $slugRedirection->setSource($slug);
                        $slugRedirection->setSourceType('trw_slug');
                        $slugRedirection->setDestination($destinationFdd);*/

                        $entityManager->persist($redirection);
                        //$entityManager->persist($slugRedirection);

                        //Moving each old redirection to the destination storageDevice
                        foreach ($fdd->getRedirections()->toArray() as $redirection) {
                            $newRedirection = new StorageDeviceIdRedirection();
                            $newRedirection->setSource($redirection->getSource());
                            $newRedirection->setSourceType($redirection->getSourceType());
                            $newRedirection->setDestination($destinationFdd);
                            $entityManager->persist($newRedirection);
                        }
                    } else {
                        throw $this->createNotFoundException(
                            'No $fdd found for id ' . $idRedirection
                        );
                    }
                }
                //Deleting the fdd
                $entityManager->remove($fdd);
                $entityManager->flush();
                return $this->render('storagedevice/delete_confirm.html.twig', [
                    'id' => $id,
                    'storageDeviceType' => 'FDD'
                ]);
            }
        }

        return $this->render('storagedevice/delete.html.twig', [
            'form' => $form->createView(),
            'storageDevice' => $fdd,
            'storageDeviceType' => 'FDD'
        ]);
    }

    public function getCriteriaFdd(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $fddManufacturerId = htmlentities($request->query->get('fddManufacturerId') ?? '');
        if ($fddManufacturerId && intval($fddManufacturerId)) {
            $criterias['manufacturer'] = "$fddManufacturerId";
        } elseif ($fddManufacturerId === "NULL") {
            $criterias['manufacturer'] = null;
        }
        return $criterias;
    }
    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();
        if ($form['fddManufacturer']->getData()) {
            if ($form['fddManufacturer']->getData()->getId() == 0) {
                $parameters['fddManufacturerId']  = "NULL";
            } else {
                $parameters['fddManufacturerId'] = $form['fddManufacturer']->getData()->getId();
            }
        }

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }
    private function _searchFormHandlerFdd(Request $request, ManufacturerRepository $manufacturerRepository,): FormInterface
    {
        $fddManufacturers = $manufacturerRepository->findAllFddManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($fddManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'fddManufacturers' => $fddManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
