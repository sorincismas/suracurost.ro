<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/contact', 'Contact::index');

// --- Rute pentru subdomeniul CRM ---
$routes->group('', ['subdomain' => 'crm', 'namespace' => 'App\Controllers\Crm'], static function ($routes) {
    // Autentificare
    $routes->get('login', 'AuthController::login', ['as' => 'crm.login']);
    $routes->get('auth/callback', 'AuthController::callback');
    $routes->get('logout', 'AuthController::logout', ['as' => 'crm.logout']);

    // --- Grup de rute protejate (necesită login) ---
    // Aici se va adăuga un filtru de autentificare
    $routes->group('', ['filter' => 'auth'], static function ($routes) {
        $routes->get('/', 'DashboardController::index', ['as' => 'crm.dashboard']);

        // Angajati
        $routes->get('angajati', 'AngajatiController::index', ['as' => 'crm.angajati']);
        $routes->get('angajati/new', 'AngajatiController::new', ['as' => 'crm.angajati.new']);
        $routes->post('angajati/create', 'AngajatiController::create');
        $routes->get('angajati/edit/(:num)', 'AngajatiController::edit/$1', ['as' => 'crm.angajati.edit']);
        $routes->post('angajati/update/(:num)', 'AngajatiController::update/$1');

        // Pontaj
        $routes->post('pontaj/start', 'PontajController::start', ['as' => 'crm.pontaj.start']);
        $routes->post('pontaj/stop', 'PontajController::stop', ['as' => 'crm.pontaj.stop']);
        $routes->get('pontaj/tabel', 'PontajController::tabel', ['as' => 'crm.pontaj.tabel']);

        // Rapoarte
        $routes->get('rapoarte/costuri', 'RapoarteController::costuriClient', ['as' => 'crm.rapoarte.costuri']);
        $routes->post('rapoarte/export', 'RapoarteController::export', ['as' => 'crm.rapoarte.export']);

        // Alte rute pentru Clienti, Proiecte, Concedii
    });
});


// ... codul existent ...

/*
 * --------------------------------------------------------------------
 * Rute pentru subdomeniul CRM
 * --------------------------------------------------------------------
 */
$routes->group('', ['subdomain' => 'crm', 'namespace' => 'App\Controllers\Crm'], static function ($routes) {
    
    // Deocamdată, nu avem un filtru de autentificare, vom adăuga mai târziu.
    // Toate rutele de mai jos vor fi accesibile pe crm.suracurost.ro

    // Dashboard
    $routes->get('/', 'DashboardController::index', ['as' => 'crm.dashboard']);

    // Angajati - CRUD
    $routes->get('angajati', 'AngajatiController::index', ['as' => 'crm.angajati']);
    $routes->get('angajati/form', 'AngajatiController::form', ['as' => 'crm.angajati.new']);
    $routes->get('angajati/form/(:num)', 'AngajatiController::form/$1', ['as' => 'crm.angajati.edit']);
    $routes->post('angajati/save', 'AngajatiController::save', ['as' => 'crm.angajati.save']);

});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
