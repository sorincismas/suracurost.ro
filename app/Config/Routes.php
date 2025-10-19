<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Adaugă aceste două linii:
$routes->resource('firme', ['controller' => 'FirmeController']);
$routes->resource('angajati', ['controller' => 'AngajatiController']);