<?php
// src/Twig/BrowserCheckerExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BrowserCheckerExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('hello', [$this, 'hello']),
            new TwigFunction('isRobot', [$this, 'isRobot']),
        ];
    }

    public function hello($ua)
    {
        return print_r(get_browser($ua));
    }

    public function isRobot($ua)
    {
        return preg_match("/Discordbot|Twitterbot/", $ua);
    }
}