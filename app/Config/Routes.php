<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Grupăm rutele CRM sub prefixul 'crm'
$routes->group('crm', static function ($routes) {
    // Rutele existente pentru Dashboard
    $routes->get('/', 'Crm\DashboardController::index'); // Dashboard-ul CRM va fi la /crm

    // Rutele existente pentru Angajati (adăugăm prefixul 'Crm\' la controller)
    $routes->get('angajati', 'Crm\AngajatiController::index');
    $routes->get('angajati/create', 'Crm\AngajatiController::create');
    $routes->post('angajati/store', 'Crm\AngajatiController::store');
    $routes->get('angajati/edit/(:num)', 'Crm\AngajatiController::edit/$1');
    $routes->post('angajati/update/(:num)', 'Crm\AngajatiController::update/$1');
    $routes->get('angajati/delete/(:num)', 'Crm\AngajatiController::delete/$1');

    // TODO: Adaugă aici și alte rute CRM pe măsură ce le dezvolți (ex: clienti, proiecte, pontaj etc.)
});


// Rutele originale (le comentăm sau ștergem dacă nu mai sunt necesare în afara /crm)
// $routes->get('/crm', 'Crm\DashboardController::index');
// $routes->get('/crm/angajati', 'Crm\AngajatiController::index');
// $routes->get('/crm/angajati/create', 'Crm\AngajatiController::create');
// $routes->post('/crm/angajati/store', 'Crm\AngajatiController::store');
// $routes->get('/crm/angajati/edit/(:num)', 'Crm\AngajatiController::edit/$1');
// $routes->post('/crm/angajati/update/(:num)', 'Crm\AngajatiController::update/$1');
// $routes->get('/crm/angajati/delete/(:num)', 'Crm\AngajatiController::delete/$1');
