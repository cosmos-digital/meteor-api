<?php

use App\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require dirname(__DIR__) . '/config/bootstrap.php';

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? $_ENV['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
if ($request->headers->get('content-type') != 'application/json') {
    $response = new Response();

    $response->setContent('You need an API client with support JSON. :)');
    $response->setStatusCode(Response::HTTP_BAD_REQUEST);

    // sets a HTTP response header
    $response->headers->set('Content-Type', 'text/html');

    // prints the HTTP headers followed by the content
    $response->send();
    $kernel->terminate($request, $response);
}
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
