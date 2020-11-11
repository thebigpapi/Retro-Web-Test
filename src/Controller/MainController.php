<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Motherboard;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage"), methods={"GET"})
     * @param Request $request
     */
    public function index(Request $request)
    {
        if($request->get('motherboard') != null) {
            return $this->redirect('./motherboard/search/');
        }
        else {
            $latestMotherboards = $this->getDoctrine()
            ->getRepository(Motherboard::class)
            ->find10Latest();
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
		'latestMotherboards' => $latestMotherboards,
            ]);
        }
    }

    /**
     * @Route("/credits", name="app_credits")
     */
    public function credits()
    {        
        return $this->render('main/credits.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/change_page/", name="change_page"), methods={"GET"})
     * @param Request $request
     */
	public function changePage(Request $request)
	{
		if($locale = $request->get('lang')) {
			$request->getSession()->set('_locale', $locale);
		}

		if($url = $request->get('goto')) {
			return $this->redirect($url);
		}

		return $this->redirect('../');
	}
}