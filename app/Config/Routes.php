<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');
$routes->post('login/autenticar', 'Login::autenticar');
$routes->get('panel/admin', 'Login::panelAdmin');
$routes->get('login/salir', 'Login::salir');

$routes->group('libros', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'LibroController::index');
    $routes->get('nuevo', 'LibroController::nuevo');
    $routes->post('guardar', 'LibroController::guardar');
    $routes->get('editar/(:num)', 'LibroController::editar/$1');
    $routes->post('actualizar/(:num)', 'LibroController::actualizar/$1');
    $routes->get('eliminar/(:num)', 'LibroController::eliminar/$1');
});

$routes->group('usuarios', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'UsuarioController::index');
    $routes->get('nuevo', 'UsuarioController::nuevo');
    $routes->post('guardar', 'UsuarioController::guardar');
    $routes->get('editar/(:num)', 'UsuarioController::editar/$1');
    $routes->post('actualizar/(:num)', 'UsuarioController::actualizar/$1');
    $routes->get('eliminar/(:num)', 'UsuarioController::eliminar/$1');
});

$routes->group('prestamos', ['filter' => 'adminbiblio'], function($routes) {
    $routes->get('/', 'PrestamoController::index');
    $routes->get('nuevo', 'PrestamoController::nuevo');
    $routes->post('guardar', 'PrestamoController::guardar');
    $routes->get('devolver/(:num)', 'PrestamoController::devolver/$1');
    $routes->get('eliminar/(:num)', 'PrestamoController::eliminar/$1');
});

$routes->group('devoluciones', ['filter' => 'adminbiblio'], function($routes) {
    $routes->get('/', 'DevolucionController::index');
    $routes->get('nuevo', 'DevolucionController::nuevo');
    $routes->get('devolver/(:num)', 'DevolucionController::devolver/$1');
    $routes->get('eliminar/(:num)', 'DevolucionController::eliminar/$1');
});

$routes->group('reportes', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'ReporteController::index');
    $routes->get('alumno', 'ReporteController::porAlumno');
    $routes->get('libro', 'ReporteController::porLibro');
    $routes->get('disponibles', 'ReporteController::librosDisponibles');
    $routes->get('activos', 'ReporteController::prestamosActivos');
});

$routes->group('alumno', ['filter' => 'alumno'], function($routes) {
    $routes->get('dashboard', 'AlumnoController::dashboard');
    $routes->get('/', 'AlumnoController::dashboard');
    $routes->get('catalogo', 'AlumnoController::catalogo');
    $routes->get('prestamos', 'AlumnoController::misPrestamos', ['as' => 'alumno_prestamos']);
});

$routes->group('bibliotecario', ['filter' => 'bibliotecario'], function($routes) {
    $routes->get('/', 'BibliotecarioController::dashboard');
    $routes->get('dashboard', 'BibliotecarioController::dashboard');
    $routes->get('prestamos', 'BibliotecarioController::redirigirAPrestamos');
    $routes->get('devoluciones', 'BibliotecarioController::redirigirADevoluciones');
});