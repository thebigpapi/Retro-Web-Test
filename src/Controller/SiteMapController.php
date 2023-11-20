<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Repository\MotherboardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteMapController extends AbstractController
{
    private $sitemapDir;
    private $projectDir;

    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
        $this->sitemapDir = $projectDir . "/public/media/sitemap/";

        if (!is_dir($this->sitemapDir)) {
            mkdir($this->sitemapDir, recursive: true);
        }
    }

    #[Route(path: '/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
    public function index(MotherboardRepository $mobos): Response
    {
        if ($this->cachedSitemapExpired()) {
            $this->refreshSitemap($mobos);
        }

        $response = new Response($this->renderView('site_map/index.xml.twig', [
            'mod_date' => $this->readLastSitemapGenTimestamp(),
            'sub_files' => $this->getSitemapFiles(),
        ]), 200);
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }

    #[Route(path: '/robots.txt', name: 'robots', defaults: ['_format' => 'txt'])]
    public function bots(): Response
    {
        return new Response($this->renderView('site_map/robots.txt.twig', []), 200);
    }

    private function readLastSitemapGenTimestamp(): string
    {
        return date("Y-m-d", $this->getSitemapGenerationTimestamp());
    }

    private function cachedSitemapExpired(): bool
    {
        $minValidity = new DateTime();
        $interval = new DateInterval("P1D"); # 1 day
        $minValidity->sub($interval);
        return $minValidity->getTimestamp() > $this->getSitemapGenerationTimestamp();
    }

    private function refreshSitemap(MotherboardRepository $mobos): void
    {
        $boards = $mobos->findAllAlphabetic("");
        $this->writeRenderedMotherboardSitemap("motherboards.xml", $boards);
        $ALL_LETTERS = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
        foreach ($ALL_LETTERS as $letter) {
            $boards = $mobos->findAllAlphabetic($letter);
            $this->writeRenderedMotherboardSitemap("motherboards." . $letter . ".xml", $boards);
        }
    }

    private function getSitemapFiles(): array
    {
        $allFiles = glob($this->sitemapDir . "*.xml");
        if ($allFiles === false) {
            return [];
        } else {
            foreach ($allFiles as &$file) {
                $file = str_replace($this->projectDir . "/public", "", $file);
            }
            return $allFiles;
        }
    }

    private function writeRenderedMotherboardSitemap(string $fileName, array $boards): void
    {
        $map = $this->renderView("site_map/board_map.xml.twig", ['boards' => $boards]);
        $fd = fopen($this->sitemapDir . $fileName, "w");
        if ($fd) {
            fwrite($fd, $map);
            fclose($fd);
        }
    }

    private function getSitemapGenerationTimestamp(): int
    {
        if (is_file($this->sitemapDir . "motherboards.xml")) {
            $fileInfo = stat($this->sitemapDir . "motherboards.xml");
            return $fileInfo["mtime"];
        }
        return 0;
    }
}
