<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Adaugă aceste două linii:
$routes->resource('firme', ['controller' => 'FirmeController']);
$routes->resource('angajati', ['controller' => 'AngajatiController']);

$routes->group('angajati', function($routes) {
    $routes->get('/', 'AngajatiController::index');
    $routes->get('new', 'AngajatiController::new');
    $routes->post('create', 'AngajatiController::create');
    $routes->get('edit/(:num)', 'AngajatiController::edit/$1');
    $routes->post('update/(:num)', 'AngajatiController::update/$1');
    $routes->get('delete/(:num)', 'AngajatiController::delete/$1');
});