<?php

namespace App\Controller;

use App\Repository\MotherboardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class SiteMapController extends AbstractController
{
    #[Route(path: '/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
    public function index(Request $request, MotherboardRepository $motherboardRepository, CacheInterface $cache): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        $urls = $cache->get("sitemapUrls" . $request->getLocale(), function () use ($motherboardRepository) {
            // Url array
            $urls = [];

            // Adding "static" urls
            $urls[] = ['loc' => $this->generateUrl('app_homepage')];
            $urls[] = ['loc' => $this->generateUrl('app_credits')];
            $urls[] = ['loc' => $this->generateUrl('motherboard_search')];
            $urls[] = ['loc' => $this->generateUrl('bios_search')];
            $urls[] = ['loc' => $this->generateUrl('bios_infoadv')];
            $urls[] = ['loc' => $this->generateUrl('bios_info')];

            // Adding urls to motherboards
            foreach ($motherboardRepository->findAllIds() as $motherboard) {
                /*$images = [
                    'loc' => '/uploads/images/featured/' . $article->getFeaturedImage(), // URL to image
                    'title' => $article->getTitre()    // Optional, text describing the image
                ];*/

                $urls[] = [
                    'loc' => $this->generateUrl('motherboard_show', [
                        'id' => $motherboard['id'],
                    ]),
                    'lastmod' => $motherboard['lastEdited']->format('Y-m-d'),
                    //'image' => $images
                ];
            }
            return $urls;
        });
        $response = new Response($this->renderView('site_map/index.xml.twig', [
            'urls' => $urls,
            'hostname' => $hostname,
        ]), 200);
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }
}
