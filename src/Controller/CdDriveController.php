<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Entity\StorageDeviceIdRedirection;
use App\Form\CdDrive\Search;
use App\Repository\CdDriveRepository;
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

class CdDriveController extends AbstractController
{
    #[Route(path: '/cddrives/{id}', name: 'cd_drive_show', requirements: ['id' => '\d+'])]
    public function cdDriveShow(int $id, CdDriveRepository $cdDriveRepository, StorageDeviceIdRedirectionRepository $storageDeviceIdRedirectionRepository)
    {
        $cdd = $cdDriveRepository->find($id);
        if (!$cdd) {
            $idRedirection = $storageDeviceIdRedirectionRepository->findRedirection($id, 'trw');

            if (!$idRedirection) {
                throw $this->createNotFoundException(
                    'No optical drive found for id ' . $id
                );
            }
            return $this->redirect($this->generateUrl('cd_drive_show', array("id" => $idRedirection)));
        }
        return $this->render('cddrive/show.html.twig', [
            'cddrive' => $cdd,
            'controller_name' => 'CdDriveController',
        ]);
    }
    #[Route(path: '/cddrives/', name: 'cddsearch', methods: ['GET'])]
    public function searchResultCdd(Request $request, PaginatorInterface $paginator, CdDriveRepository $cddRepository, ManufacturerRepository $manufacturerRepository)
    {
        $latestCdds = $cddRepository->findLatest(8);
        $form = $this->_searchFormHandlerCdd($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('cddsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaCdd($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('cddrive/search.html.twig', [
                'form' => $form->createView(),
                'latestCdds' => $latestCdds,
            ]);
        }

        $data = $cddRepository->findByCdd($criterias);
        $cdds = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('cddrive/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'CdDriveController',
            'cdds' => $cdds,
        ]);

    }
    #[Route('/cddrives/live', name: 'cddlivewrapper')]
    public function liveSearchCdd(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerCdd($request, $manufacturerRepository);
        return $this->redirect($this->generateUrl('cddlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/cddrives/results', name: 'cddlivesearch')]
    public function liveResultsCdd(Request $request, PaginatorInterface $paginator, CdDriveRepository $cddRepository): Response
    {
        $criterias = $this->getCriteriaCdd($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $cddRepository->findByCdd($criterias);
        $cdds = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/cddrives/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('cddrive/result.html.twig', [
            'controller_name' => 'CdDriveController',
            'cdds' => $cdds,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }

    #[Route('/dashboard/cd-drive-delete/{id}', name: 'cd_drive_delete', requirements: ["id" => "\d+"])]
    public function delete(
        Request $request,
        int $id,
        CdDriveRepository $cdDriveRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $cdd = $cdDriveRepository->find($id);

        if (!$cdd) {
            throw $this->createNotFoundException(
                'No $cdd found for id ' . $id
            );
        }
        //$slug = $cdd->getSlug();

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
                return $this->redirect($this->generateUrl('cd_drive_show', array("id" => $id)));
            }
            if ($yesButton->isClicked()) {
                //If user selected a cdd where the current id will redirect to
                if ($form->get('Redirection') && !is_null($form->get('Redirection')->getData())) {
                    $idRedirection = $form->get('Redirection')->getData();
                    $destinationCdd = $cdDriveRepository->find($idRedirection);


                    if ($destinationCdd) {
                        //Creating new redirection
                        $redirection = new StorageDeviceIdRedirection();
                        $redirection->setSource($id);
                        $redirection->setSourceType('trw');
                        $redirection->setDestination($destinationCdd);

                        /*$slugRedirection = new StorageDeviceIdRedirection();
                        $slugRedirection->setSource($slug);
                        $slugRedirection->setSourceType('trw_slug');
                        $slugRedirection->setDestination($destinationCdd);*/

                        $entityManager->persist($redirection);
                        //$entityManager->persist($slugRedirection);

                        //Moving each old redirection to the destination storageDevice
                        foreach ($cdd->getRedirections()->toArray() as $redirection) {
                            $newRedirection = new StorageDeviceIdRedirection();
                            $newRedirection->setSource($redirection->getSource());
                            $newRedirection->setSourceType($redirection->getSourceType());
                            $newRedirection->setDestination($destinationCdd);
                            $entityManager->persist($newRedirection);
                        }
                    } else {
                        throw $this->createNotFoundException(
                            'No $cdd found for id ' . $idRedirection
                        );
                    }
                }
                //Deleting the cdd
                $entityManager->remove($cdd);
                $entityManager->flush();
                return $this->render('storagedevice/delete_confirm.html.twig', [
                    'id' => $id,
                    'storageDeviceType' => 'CDD'
                ]);
            }
        }

        return $this->render('storagedevice/delete.html.twig', [
            'form' => $form->createView(),
            'storageDevice' => $cdd,
            'storageDeviceType' => 'CDD'
        ]);
    }

    public function getCriteriaCdd(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        $cddManufacturerId = htmlentities($request->query->get('cddManufacturerId') ?? '');
        if ($cddManufacturerId && intval($cddManufacturerId)) {
            $criterias['manufacturer'] = "$cddManufacturerId";
        } elseif ($cddManufacturerId === "NULL") {
            $criterias['manufacturer'] = null;
        }
        return $criterias;
    }
    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();
        if ($form['cddManufacturer']->getData()) {
            if ($form['cddManufacturer']->getData()->getId() == 0) {
                $parameters['cddManufacturerId']  = "NULL";
            } else {
                $parameters['cddManufacturerId'] = $form['cddManufacturer']->getData()->getId();
            }
        }

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }
    private function _searchFormHandlerCdd(Request $request, ManufacturerRepository $manufacturerRepository,): FormInterface
    {
        $cddManufacturers = $manufacturerRepository->findAllCddManufacturer();
        $unidentifiedMan = new Manufacturer();
        $unidentifiedMan->setName("Not identified");
        array_unshift($cddManufacturers, $unidentifiedMan);

        $form = $this->createForm(Search::class, array(), [
            'cddManufacturers' => $cddManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }
}
