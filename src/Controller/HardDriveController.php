<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Entity\StorageDeviceIdRedirection;
use App\Form\HardDrive\Search;
use App\Repository\HardDriveRepository;
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

class HardDriveController extends AbstractController
{
    #[Route(path: '/harddrives/{id}', name: 'hard_drive_show', requirements: ['id' => '\d+'])]
    public function hardDriveShow(int $id, HardDriveRepository $hardDriveRepository, StorageDeviceIdRedirectionRepository $storageDeviceIdRedirectionRepository)
    {
        $hdd = $hardDriveRepository->find($id);
        if (!$hdd) {
            $idRedirection = $storageDeviceIdRedirectionRepository->findRedirection($id, 'trw');

            if (!$idRedirection) {
                throw $this->createNotFoundException(
                    'No hard drive found for id ' . $id
                );
            } 
            return $this->redirect($this->generateUrl('hard_drive_show', array("id" => $idRedirection)));
        } 

        return $this->render('harddrive/show.html.twig', [
            'harddrive' => $hdd,
            'controller_name' => 'HardDriveController',
        ]);
    }
    #[Route(path: '/harddrives/', name: 'hddsearch', methods: ['GET'])]
    public function searchResultHdd(Request $request, PaginatorInterface $paginator, HardDriveRepository $hddRepository, ManufacturerRepository $manufacturerRepository)
    {
        $form = $this->_searchFormHandlerHdd($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('hddsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaHdd($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('harddrive/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $data = $hddRepository->findByHdd($criterias);
        $hdds = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('harddrive/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'HardDriveController',
            'hdds' => $hdds,
            'show_images' => $showImages,
        ]);
    }
    #[Route('/harddrives/live', name: 'hddlivewrapper')]
    public function liveSearchHdd(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerHdd($request, $manufacturerRepository);
        return $this->redirect($this->generateUrl('hddlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/harddrives/results', name: 'hddlivesearch')]
    public function liveResultsHdd(Request $request, PaginatorInterface $paginator, HardDriveRepository $hddRepository): Response
    {
        $criterias = $this->getCriteriaHdd($request);
        $showImages = boolval(htmlentities($request->query->get('showImages') ?? ''));
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $hddRepository->findByHdd($criterias);
        $hdds = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/harddrives/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('harddrive/result.html.twig', [
            'controller_name' => 'HardDriveController',
            'hdds' => $hdds,
            'show_images' => $showImages,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaHdd(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $capacity = htmlentities($request->query->get('capacity') ?? '');
        if ($capacity) {
            $criterias['capacity'] = "$capacity";
        }
        $hddManufacturerId = htmlentities($request->query->get('hddManufacturerId') ?? '');
        if ($hddManufacturerId && intval($hddManufacturerId)) {
            $criterias['manufacturer'] = "$hddManufacturerId";
        } elseif ($hddManufacturerId === "NULL") {
            $criterias['manufacturer'] = null;
        }
        return $criterias;
    }

    #[Route('/dashboard/hard-drive-delete/{id}', name: 'hard_drive_delete', requirements: ["id" => "\d+"])]
    public function delete(
        Request $request,
        int $id,
        HardDriveRepository $hardDriveRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $hdd = $hardDriveRepository->find($id);

        if (!$hdd) {
            throw $this->createNotFoundException(
                'No $hdd found for id ' . $id
            );
        }
        //$slug = $hdd->getSlug();

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
                return $this->redirect($this->generateUrl('hard_drive_show', array("id" => $id)));
            }
            if ($yesButton->isClicked()) {
                //If user selected a hdd where the current id will redirect to
                if ($form->get('Redirection') && !is_null($form->get('Redirection')->getData())) {
                    $idRedirection = $form->get('Redirection')->getData();
                    $destinationHdd = $hardDriveRepository->find($idRedirection);


                    if ($destinationHdd) {
                        //Creating new redirection
                        $redirection = new StorageDeviceIdRedirection();
                        $redirection->setSource($id);
                        $redirection->setSourceType('trw');
                        $redirection->setDestination($destinationHdd);

                        /*$slugRedirection = new StorageDeviceIdRedirection();
                        $slugRedirection->setSource($slug);
                        $slugRedirection->setSourceType('trw_slug');
                        $slugRedirection->setDestination($destinationHdd);*/

                        $entityManager->persist($redirection);
                        //$entityManager->persist($slugRedirection);

                        //Moving each old redirection to the destination motherboard
                        foreach ($hdd->getRedirections()->toArray() as $redirection) {
                            $newRedirection = new StorageDeviceIdRedirection();
                            $newRedirection->setSource($redirection->getSource());
                            $newRedirection->setSourceType($redirection->getSourceType());
                            $newRedirection->setDestination($destinationHdd);
                            $entityManager->persist($newRedirection);
                        }
                    } else {
                        throw $this->createNotFoundException(
                            'No $hdd found for id ' . $idRedirection
                        );
                    }
                }
                //Deleting the motherboard
                $entityManager->remove($hdd);
                $entityManager->flush();
                return $this->render('storagedevice/delete_confirm.html.twig', [
                    'id' => $id,
                    'storageDeviceType' => 'HDD'
                ]);
            }
        }

        return $this->render('storagedevice/delete.html.twig', [
            'form' => $form->createView(),
            'storageDevice' => $hdd,
            'storageDeviceType' => 'HDD'
        ]);
    }

    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();
        if ($form['hddManufacturer']->getData()) {
            if ($form['hddManufacturer']->getData()->getId() == 0) {
                $parameters['hddManufacturerId']  = "NULL";
            } else {
                $parameters['hddManufacturerId'] = $form['hddManufacturer']->getData()->getId();
            }
        }

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['showImages'] = $form['searchWithImages']->getData();
        $parameters['name'] = $form['name']->getData();
        $parameters['capacity'] = $form['capacity']->getData();

        return $parameters;
    }
    private function _searchFormHandlerHdd(Request $request, ManufacturerRepository $manufacturerRepository,): FormInterface
    {
        $hddManufacturers = $manufacturerRepository->findAllHddManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($hddManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'hddManufacturers' => $hddManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }

    #[Route('/harddrives/help', name: 'hddhelp')]
    public function searchHelp(): Response {
        return $this->render('harddrive/help.html.twig', [
            'controller_name' => 'HardDriveController',
        ]);
    }
}
