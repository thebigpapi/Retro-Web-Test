<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Bios\Search;
use App\Repository\ManufacturerRepository;
use App\Repository\MotherboardBiosRepository;

class BiosController extends AbstractController
{
    #[Route(path: '/bios/', name: 'biossearch', methods: ['GET', 'POST'])]
    public function searchResultBios(Request $request, PaginatorInterface $paginator, MotherboardBiosRepository $motherboardBiosRepository, ManufacturerRepository $manufacturerRepository)
    {
        $latestBios = $motherboardBiosRepository->findLatest(14);
        $form = $this->_searchFormHandlerBios($request, $manufacturerRepository);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('biossearch', $this->searchFormToParamBios($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaBios($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('bios/search.html.twig', [
                'form' => $form->createView(),
                'latestBios' => $latestBios,
            ]);
        }
        $data = $motherboardBiosRepository->findBios($criterias);
        $bios = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('bios/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'BiosController',
            'bios' => $bios,
        ]);
    }

    #[Route('/bios/live', name: 'bioslivewrapper')]
    public function liveSearchBios(Request $request, ManufacturerRepository $manufacturerRepository): Response
    {
        $form = $this->_searchFormHandlerBios($request, $manufacturerRepository);

        return $this->redirect($this->generateUrl('bioslivesearch', $this->searchFormToParamBios($request, $form)));
    }

    #[Route('/bios/results', name: 'bioslivesearch')]
    public function liveResultsBios(Request $request, PaginatorInterface $paginator, MotherboardBiosRepository $motherboardBiosRepository): Response
    {
        $criterias = $this->getCriteriaBios($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $motherboardBiosRepository->findBios($criterias);
        $bios = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/bios/?";
        foreach ($request->query as $key => $value){
            if($key == "chipIds"){
                foreach($value as $idx => $val){
                    $string .= $key . '%5B' . $idx . '%5D=' . $val .'&';
                }
            }
            else{
                if($key != "domTarget")
                    $string .= $key . '=' . $value . '&';
            }
        }
        return $this->render('bios/result.html.twig', [
            'controller_name' => 'BiosController',
            'bios' => $bios,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaBios(Request $request){
        $criterias = array();
        $postString = $request->query->get('postString');
        if ($postString) {
            $criterias['post_string'] = "$postString";
        }
        $biosVersion = htmlentities($request->query->get('biosVersion') ?? '');
        if ($biosVersion) {
            $criterias['bios_version'] = "$biosVersion";
        }
        $coreVersion = htmlentities($request->query->get('coreVersion') ?? '');
        if ($coreVersion) {
            $criterias['core_version'] = "$coreVersion";
        }
        $biosManufacturerId = htmlentities($request->query->get('biosManufacturerId') ?? '');
        if ($biosManufacturerId && intval($biosManufacturerId)) {
            $criterias['manufacturer_id'] = intval($biosManufacturerId);
        } elseif ($biosManufacturerId == "NULL") {
            $criterias['manufacturer_id'] = null;
        }
        $moboManufacturerId = htmlentities($request->query->get('moboManufacturerId') ?? '');
        if ($moboManufacturerId && intval($moboManufacturerId)) {
            $criterias['mbmanufacturer_id'] = intval($moboManufacturerId);
        } elseif ($moboManufacturerId == "NULL") {
            $criterias['mbmanufacturer_id'] = null;
        }
        $filePresent = htmlentities($request->query->get('filePresent') ?? '');
        if ($filePresent && boolval($filePresent)) {
            $criterias['file_present'] = boolval($filePresent);
        }
        $fileName = htmlentities($request->query->get('fileName') ?? '');
        if ($fileName) {
            $criterias['file_name'] = "$fileName";
        }
        $chipsetId = htmlentities($request->query->get('chipsetId') ?? '');
        if ($chipsetId && intval($chipsetId)) {
            $criterias['chipset_id'] = intval($chipsetId);
        } elseif ($chipsetId == "NULL") {
            $criterias['chipset_id'] = null;
        }
        $chipIds = $request->query->all('chipIds') ?? $request->request->all('chipIds');
        $chipArray = null;
        if ($chipIds) {
            if (is_array($chipIds)) {
                $chipArray = $chipIds;
            } else {
                $chipArray = json_decode($chipIds);
            }
            $criterias['chips'] = $chipArray;
        }
        return $criterias;
    }
    private function searchFormToParamBios(Request $request, $form): array
    {
        $parameters = array();

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        if ($postString = $form['post_string']->getData()) {
            $parameters['postString'] = $postString;
        }
        if ($biosVersion = $form['bios_version']->getData()) {
            $parameters['biosVersion'] = $biosVersion;
        }
        if ($coreVersion = $form['core_version']->getData()) {
            $parameters['coreVersion'] = $coreVersion;
        }
        if ($fileName = $form['file_name']->getData()) {
            $parameters['fileName'] = $fileName;
        }
        if ($biosManufacturer = $form['manufacturer']->getData()) {
            $parameters['biosManufacturerId'] = $biosManufacturer->getId();
        }
        if ($moboManufacturer = $form['moboManufacturer']->getData()) {
            $parameters['moboManufacturerId'] = $moboManufacturer->getId();
        }
        $chips = $form['chips']->getData();
        if ($chips) {
            $parameters['chipIds'] = array();
            $loopCount = 0;
            foreach ($chips as $chip) {
                if($loopCount >= 6)
                    break;
                if($chip != null)
                    array_push($parameters['chipIds'], $chip->getId());
            }
        }
        if ($filePresent = $form['file_present']->getData()) {
            $parameters['filePresent'] = $filePresent;
        }
        if ($form['chipset']->getData()) {
            if ($form['chipset']->getData()->getId() == 0) {
                if ($form['chipset']->getData()->getName() == " chipset of any kind"){
                    $parameters['chipsetManufacturerId'] = $form['chipset']->getData()->getManufacturer()->getId();
                }
                else{
                    $parameters['chipsetId']  = "NULL";
                }
            }
            else {
                $parameters['chipsetId'] = $form['chipset']->getData()->getId();
            }

        }

        return $parameters;
    }
    private function _searchFormHandlerBios(Request $request, ManufacturerRepository $manufacturerRepository): FormInterface
    {
        $biosManufacturers = $manufacturerRepository->findAllBiosManufacturer();
        $moboManufacturers = $manufacturerRepository->findAllMotherboardManufacturer();
        $form = $this->createForm(Search::class, array(), [
            'biosManufacturers' => $biosManufacturers,
            'moboManufacturers' => $moboManufacturers,
        ]);

        $form->handleRequest($request);

        return $form;
    }

    #[Route(path: '/bios/list', name: 'bios_list')]
    public function biosList(ManufacturerRepository $manufacturerRepository)
    {
        $biosCodes = $manufacturerRepository->findAllBiosManufacturerAdv();
        $chipdata = $manufacturerRepository->findAllChipsetBiosManufacturer();
        $chipCodes = [];
        foreach($chipdata as $manuf => $arr){
            $key = "";
            $val = "";
            $code = [];
            foreach($arr as $row){
                if($row[0] == $key){
                    if($row[1] != $val){
                        if($val == "")
                            $val = $row[0] . ": " . $manuf . " ";
                        $val .= ", " . $row[1];
                    }
                }
                else{
                    if($val != ""){
                        array_push($code, $val);
                        $val = "";
                    }
                    if($val == "")
                        $val = $row[0] . ": " . $manuf . " " . $row[1];
                }
                $key = $row[0];
            }
            $chipCodes[$manuf] = $code;
        }
        return $this->render('bios/list.html.twig', [
            'controller_name' => 'MainController',
            'biosCodes' => $biosCodes,
            'chipCodes' => $chipCodes,
        ]);
    }
    #[Route('/bios/bot/string', name:'bios_bot_string', methods:['POST'])]
    public function getBIOSListString(Request $request, MotherboardBiosRepository $motherboardBiosRepository): JsonResponse
    {
        $string = $request->request->get('string');
        $filename1 = $request->request->get('filename1');
        $filename2 = $request->request->get('filename2');
        if($string == '' || $filename1 == '' || $filename2 == '')
            return new JsonResponse([]);
        $boards = $motherboardBiosRepository->findByString($string);
        if(count($boards) > 0)
            return new JsonResponse($boards);
        else{
            $boards = $motherboardBiosRepository->findByFilename($filename1, $filename2);
            if(count($boards) > 0)
                return new JsonResponse($boards);
        }
        return new JsonResponse([]);
    }
    #[Route('/bios/bot/hash', name:'bios_bot_hash', methods:['POST', 'GET'])]
    public function getBIOSListHash(Request $request, MotherboardBiosRepository $motherboardBiosRepository): JsonResponse
    {
        $list = json_decode($request->request->get('list'));
        $output = [];
        foreach($list as $file => $hash){
            $output[$file] = $motherboardBiosRepository->findByHash($hash);
        }
        return new JsonResponse($output);
    }

    #[Route('/bios/help', name: 'bioshelp')]
    public function searchHelp(): Response {
        return $this->render('bios/help.html.twig', [
            'controller_name' => 'BiosController',
        ]);
    }
}
