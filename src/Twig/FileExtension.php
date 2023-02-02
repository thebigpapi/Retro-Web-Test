<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FileExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return array(
            new TwigFilter('ext', array($this, 'ext')),
            new TwigFilter('force_to_int', fn ($value) => intval($value)),
        );
    }

    public function ext($filepath)
    {
        $ext = pathinfo($filepath, PATHINFO_EXTENSION);
        return $ext;
    }
}
