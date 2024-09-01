<?php

namespace App\Controller;

use App\Form\Socket\Search;
use App\Repository\CpuSocketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;

class SocketController extends AbstractController
{
    #[Route('/sockets/{id}', name: 'socket_show', requirements: ['id' => '\d+'])]
    public function showSocket(int $id, CpuSocketRepository $cpuSocketepository): Response {
        $socket = $cpuSocketepository->find($id);

        if (!$socket) {
            throw $this->createNotFoundException(
                'No socket found for id ' . $id
            );
        }
        return $this->render('socket/show.html.twig', [
            'socket' => $socket,
            'controller_name' => 'SocketController',
        ]);
    }

    #[Route('/sockets/', name: 'socketsearch')]
    public function searchResultSocket(Request $request, PaginatorInterface $paginator, CpuSocketRepository $cpuSocketepository): Response {
        $form = $this->_searchFormHandlerSocket($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('socketsearch', $this->searchFormToParam($request, $form)));
        }
        //get criterias
        $criterias = $this->getCriteriaSocket($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        if (empty($criterias)) {
            return $this->render('socket/search.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $data = $cpuSocketepository->findBySocket($criterias);
        $sockets = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            $maxItems
        );
        return $this->render('socket/search.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'SocketController',
            'sockets' => $sockets,
        ]);
    }

    #[Route('/sockets/live', name: 'socketlivewrapper')]
    public function liveSearchSocket(Request $request): Response
    {
        $form = $this->_searchFormHandlerSocket($request);
        return $this->redirect($this->generateUrl('socketlivesearch', $this->searchFormToParam($request, $form)));
    }

    #[Route('/sockets/results', name: 'socketlivesearch')]
    public function liveResultsSocket(Request $request, PaginatorInterface $paginator, CpuSocketRepository $cpuSocketepository): Response
    {
        $criterias = $this->getCriteriaSocket($request);
        $maxItems = $request->query->getInt('itemsPerPage', $request->request->getInt('itemsPerPage', $this->getParameter('app.pagination.max')));
        $data = $cpuSocketepository->findBySocket($criterias);
        $sockets = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                $maxItems
            );
        $string = "/sockets/?";
        foreach ($request->query as $key => $value){
            if($key != "domTarget")
                $string .= $key . '=' . $value . '&';
        }
        return $this->render('socket/result.html.twig', [
            'controller_name' => 'SocketController',
            'sockets' => $sockets,
            'domTarget' => $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "",
            'params' => substr($string, 0, -1),
        ]);
    }
    public function getCriteriaSocket(Request $request){
        $criterias = array();
        $name = htmlentities($request->query->get('name') ?? '');
        if ($name) {
            $criterias['name'] = "$name";
        }
        return $criterias;
    }
    private function searchFormToParam(Request $request, $form): array
    {
        $parameters = array();

        $parameters['page'] = intval($request->request->get('page') ?? $request->query->get('page') ?? 1);
        $parameters['domTarget'] = $request->request->get('domTarget') ?? $request->query->get('domTarget') ?? "";

        $tempItems = intval($form['itemsPerPage']->getData()->value);
        $parameters['itemsPerPage'] = $tempItems > 0 ? $tempItems : $this->getParameter('app.pagination.max');

        $parameters['name'] = $form['name']->getData();

        return $parameters;
    }
    private function _searchFormHandlerSocket(Request $request): FormInterface
    {
        $form = $this->createForm(Search::class, array(), []);
        $form->handleRequest($request);
        return $form;
    }
}