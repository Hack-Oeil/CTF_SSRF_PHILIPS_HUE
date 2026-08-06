<?php
error_reporting(0);
ini_set('display_errors', 0);
stream_wrapper_unregister("http");
stream_wrapper_unregister("https");

$_ENV['DEFAULT_CTF_FLAG'] = 'e2d90f1a3e209919fde49e45d240361357ca5297';

// On securise le cookie de session (PHPSESSID)
session_set_cookie_params(60 * 60, null, null, false, true);

require __DIR__.'/waiting_or_autoload.php';

$kernel = new Yoop\Kernel();
(new Yoop\Database\Wait)->tryMySQL();


$csp = $kernel->contentSecurityPolicy();
$csp->enableStrictMode(false);
$csp->addStyleSrc(['https://fonts.googleapis.com', 'https://fonts.googleapis.com/css2', 'https://cdnjs.cloudflare.com']);
$csp->addFontSrc(['https://fonts.gstatic.com', 'https://cdnjs.cloudflare.com']);
$csp->addScriptSrc(["'unsafe-inline'"]);


function __(string $trad, array $p = [])
{
    global $kernel;
    return $kernel->__($trad, $p);
}

$router = $kernel->getRouter();
$router->load('/app/routes.php');
$router->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);