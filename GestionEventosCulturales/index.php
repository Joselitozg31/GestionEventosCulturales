<?php

require_once __DIR__ . '/vendor/autoload.php';

use FastRoute\RouteCollector;
use Dotenv\Dotenv;
use App\Controlador\AuthController;
use App\Controlador\ArtistaController;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    // Rutas para autenticación
    $r->addRoute('GET', '/login', ['App\Controlador\AuthController', 'mostrarLogin']);
    $r->addRoute('POST', '/login', ['App\Controlador\AuthController', 'procesarLogin']);
    $r->addRoute('GET', '/register', ['App\Controlador\AuthController', 'mostrarRegistro']);
    $r->addRoute('POST', '/register', ['App\Controlador\AuthController', 'procesarRegistro']);
    $r->addRoute('GET', '/validacion', ['App\Controlador\AuthController', 'mostrarValidacion']);
    $r->addRoute('POST', '/validacion', ['App\Controlador\AuthController', 'procesarValidacion']);

    // Rutas para artistas
    $r->addRoute('GET', '/', ['App\Controlador\ArtistaController', 'mostrarArtistas']);
    $r->addRoute('GET', '/artistas', ['App\Controlador\ArtistaController', 'mostrarArtistas']);
    $r->addRoute('GET', '/artistas/{id:\d+}', ['App\Controlador\ArtistaController', 'mostrarArtista']);
    $r->addRoute('GET', '/artistas/crear', ['App\Controlador\ArtistaController', 'crearArtista']);
    $r->addRoute('POST', '/artistas/crear', ['App\Controlador\ArtistaController', 'insertarArtista']);
    $r->addRoute('GET', '/artistas/{id:\d+}/eliminar', ['App\Controlador\ArtistaController', 'eliminarArtista']);
    $r->addRoute('POST', '/artistas/{id:\d+}/modificar', ['App\Controlador\ArtistaController', 'modificarArtista']);
    $r->addRoute('GET', '/artistas/{id:\d+}/modificar', ['App\Controlador\ArtistaController', 'mostrarModificarArtista']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Procesar la solicitud
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // No se encontró la ruta
        http_response_code(404);
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        // Método no permitido
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        // Ruta encontrada
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;
        $controllerInstance = new $controller();
        call_user_func_array([$controllerInstance, $method], [$vars]);
        break;
}