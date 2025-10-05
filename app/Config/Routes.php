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


// Rutas para la gestión de Usuarios (CRUD)
$routes->group('usuarios', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'UsuarioController::index');              // READ: Lista de usuarios
    $routes->get('nuevo', 'UsuarioController::nuevo');         // CREATE (Vista): Formulario nuevo
    $routes->post('guardar', 'UsuarioController::guardar');    // CREATE (Acción): Guardar
    $routes->get('editar/(:num)', 'UsuarioController::editar/$1'); // UPDATE (Vista): Formulario editar
    $routes->post('actualizar/(:num)', 'UsuarioController::actualizar/$1'); // UPDATE (Acción): Actualizar
    $routes->get('eliminar/(:num)', 'UsuarioController::eliminar/$1'); // DELETE: Eliminar
});

// En app/Config/Routes.php

// Rutas para la gestión de Préstamos (CRUD)
$routes->group('prestamos', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'PrestamoController::index');             // READ: Lista de préstamos
    $routes->get('nuevo', 'PrestamoController::nuevo');         // CREATE (Vista): Formulario nuevo préstamo
    $routes->post('guardar', 'PrestamoController::guardar');   // CREATE (Acción): Registrar préstamo
    
    // Acciones específicas
    $routes->get('devolver/(:num)', 'PrestamoController::devolver/$1'); // UPDATE: Marcar devolución
    $routes->get('eliminar/(:num)', 'PrestamoController::eliminar/$1'); // DELETE: Eliminar registro
});