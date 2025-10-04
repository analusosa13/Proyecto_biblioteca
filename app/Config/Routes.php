<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');
$routes->post('login/autenticar', 'Login::autenticar');
// Rutas para los paneles específicos
$routes->get('panel/admin', 'Login::panelAdmin');
$routes->get('panel/alumno', 'Login::panelAlumno');
$routes->get('login/salir', 'Login::salir');


// Rutas para la gestión de Libros (CRUD)
$routes->group('libros', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'LibroController::index');              // READ: Lista de libros
    $routes->get('nuevo', 'LibroController::nuevo');         // CREATE (Vista): Formulario nuevo
    $routes->post('guardar', 'LibroController::guardar');    // CREATE (Acción): Guardar
    $routes->get('editar/(:num)', 'LibroController::editar/$1'); // UPDATE (Vista): Formulario editar
    $routes->post('actualizar/(:num)', 'LibroController::actualizar/$1'); // UPDATE (Acción): Actualizar
    $routes->get('eliminar/(:num)', 'LibroController::eliminar/$1'); // DELETE: Eliminar
});

