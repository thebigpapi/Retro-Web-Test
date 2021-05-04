<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

$local = "/uh19";
require dirname(__DIR__).$local.'/vendor/autoload.php';

$dir = dirname($_SERVER['SCRIPT_NAME']);
define('app.path', (in_array($dir, array('/','\\'))) ? '' : $dir);
define('web.path', $_SERVER['DOCUMENT_ROOT']);

(new Dotenv())->bootEnv(dirname(__DIR__).$local.'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
