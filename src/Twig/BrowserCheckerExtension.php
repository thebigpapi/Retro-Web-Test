<?php
// src/Twig/BrowserCheckerExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\TwigFunction;

class BrowserCheckerExtension extends AbstractExtension
{

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        //$this->container = new ContainerBuilder();
        //$this->container->compile();
    }

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
        $robots = $this->params->get("user_agent.crawlers");
        
        $match = "/";
        foreach ($robots as $key => $robot)
        {
            if (array_key_first($robots) == $key)
                $match = $match . $robot;
            else
                $match = $match . "|" . $robot;
        }
        $match = $match . "/";
        return preg_match($match, $ua);
    }
}