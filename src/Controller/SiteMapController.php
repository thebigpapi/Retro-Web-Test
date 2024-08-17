<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\CdDriveRepository;
use App\Repository\ChipsetRepository;
use App\Repository\ExpansionChipRepository;
use App\Repository\FloppyDriveRepository;
use App\Repository\HardDriveRepository;
use App\Repository\LargeFileRepository;
use App\Repository\MotherboardRepository;
use App\Repository\ProcessorRepository;

use DateTime;
use DateInterval;

class SiteMapController extends AbstractController
{
    private $sitemapDir;
    private $projectDir;
    private $lastGenMarkerFile;

    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
        $this->sitemapDir = $projectDir . "/public/media/sitemap/";
        $this->lastGenMarkerFile = $this->sitemapDir . "lastGen";

        if (!is_dir($this->sitemapDir)) {
            mkdir($this->sitemapDir, recursive: true);
        }
    }

    #[Route(path: '/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
    public function index(
        MotherboardRepository $mobos,
        ExpansionChipRepository $chips,
        ChipsetRepository $chipsets,
        ProcessorRepository $cpus,
        HardDriveRepository $hdds,
        CdDriveRepository $odds,
        FloppyDriveRepository $fdds,
        LargeFileRepository $files
    ): Response {
        if ($this->cachedSitemapExpired()) {
            $this->refreshSitemap($mobos, $chips, $chipsets, $cpus, $hdds, $odds, $fdds, $files);
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

    private function refreshSitemap(
        MotherboardRepository $mobos,
        ExpansionChipRepository $chips,
        ChipsetRepository $chipsets,
        ProcessorRepository $cpus,
        HardDriveRepository $hdds,
        CdDriveRepository $odds,
        FloppyDriveRepository $fdds,
        LargeFileRepository $files
    ): void {
        $ALL_LETTERS = str_split("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ");

        # Write motherboards
        $moboSet = $mobos->findAllAlphabetic("");
        $this->writeRenderedSitemap("motherboards.xml", "motherboard_show", $moboSet);
        foreach ($ALL_LETTERS as $letter) {
            $moboSet = $mobos->findAllAlphabetic($letter);
            $this->writeRenderedSitemap("motherboards." . $letter . ".xml", "motherboard_show", $moboSet);
        }

        # Write expansion chips
        $chipSet = $chips->findAllAlphabetic("");
        $this->writeRenderedSitemap("chip.xml", "chip_show", $chipSet);
        foreach ($ALL_LETTERS as $letter) {
            $chipSet = $chips->findAllAlphabetic($letter);
            $this->writeRenderedSitemap("chip." . $letter . ".xml", "chip_show", $chipSet);
        }

        # Write chipsets
        $chipsetSet = $chipsets->findAllAlphabetic("");
        $this->writeRenderedSitemap("chipset.xml", "chipset_show", $chipsetSet);
        foreach ($ALL_LETTERS as $letter) {
            $chipsetSet = $chipsets->findAllAlphabetic($letter);
            $this->writeRenderedSitemap("chipset." . $letter . ".xml", "chipset_show", $chipsetSet);
        }

        /*# Write CPUs
        $cpuSet = $cpus->findAllAlphabetic("");
        $this->writeRenderedSitemap("cpu.xml", "processor_show", $cpuSet);
        foreach ($ALL_LETTERS as $letter) {
            $cpuSet = $cpus->findAllAlphabetic($letter);
            $this->writeRenderedSitemap("cpu." . $letter . ".xml", "processor_show", $cpuSet);
        }*/

        # Write hard drives
        $hddSet = $hdds->findAllAlphabetic("");
        $this->writeRenderedSitemap("hdd.xml", "hard_drive_show", $hddSet);
        foreach ($ALL_LETTERS as $letter) {
            $hddSet = $hdds->findAllAlphabetic($letter);
            $this->writeRenderedSitemap("hdd." . $letter . ".xml", "hard_drive_show", $hddSet);
        }

        # Write optical drives
        $oddSet = $odds->findAllAlphabetic("");
        $this->writeRenderedSitemap("odd.xml", "cd_drive_show", $oddSet);
        foreach ($ALL_LETTERS as $letter) {
            $oddSet = $odds->findAllAlphabetic($letter);
            $this->writeRenderedSitemap("odd." . $letter . ".xml", "cd_drive_show", $oddSet);
        }

        # Write floppy drives
        $fddSet = $fdds->findAllAlphabetic("");
        $this->writeRenderedSitemap("fdd.xml", "floppy_drive_show", $fddSet);
        foreach ($ALL_LETTERS as $letter) {
            $fddSet = $fdds->findAllAlphabetic($letter);
            $this->writeRenderedSitemap("fdd." . $letter . ".xml", "floppy_drive_show", $fddSet);
        }

        # Write drivers and other large files
        # Files don't have a Manufacturer, search goes by full name. No need for empty search key
        foreach ($ALL_LETTERS as $letter) {
            $fileSet = $files->findAllAlphabetic($letter);
            $this->writeRenderedSitemap("drv." . $letter . ".xml", "driver_show", $fileSet);
        }

        touch($this->lastGenMarkerFile);
    }

    private function getSitemapFiles(): array
    {
        $allFiles = glob($this->sitemapDir . "*.xml");
        if ($allFiles === false) {
            return [];
        } else {
            # Trim absolute path so it's relative to hostname
            foreach ($allFiles as &$file) {
                $file = str_replace($this->projectDir . "/public", "", $file);
            }
            return $allFiles;
        }
    }

    private function writeRenderedSitemap(string $fileName, string $appRoute, array $items): void
    {
        # Don't generate file if there's nothing to be written.
        if (empty($items)) {
            return;
        }

        $map = $this->renderView("site_map/item_map.xml.twig", ['items' => $items, 'route' => $appRoute]);
        $fd = fopen($this->sitemapDir . $fileName, "w");
        if ($fd) {
            fwrite($fd, $map);
            fclose($fd);
        }
    }

    private function getSitemapGenerationTimestamp(): int
    {
        if (is_file($this->lastGenMarkerFile)) {
            $fileInfo = stat($this->lastGenMarkerFile);
            return $fileInfo["mtime"];
        }
        return 0;
    }
}
