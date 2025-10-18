<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// Poți adăuga aici o rută pentru pagina de contact a site-ului principal, dacă este necesar.
// $routes->get('/contact', 'ContactController::index');


/*
 * --------------------------------------------------------------------
 * Rute pentru subdomeniul CRM
 * --------------------------------------------------------------------
 */
$routes->group('', ['subdomain' => 'crm', 'namespace' => 'App\Controllers\Crm'], static function ($routes) {
    
    // Rute Publice (Autentificare)
    // $routes->get('login', 'AuthController::login', ['as' => 'crm.login']);
    // $routes->get('auth/callback', 'AuthController::callback');
    // $routes->get('logout', 'AuthController::logout', ['as' => 'crm.logout']);

    // --- Grup de rute protejate (necesită login) ---
    // Când vom implementa autentificarea, vom activa filtrul de mai jos.
    // $routes->group('', ['filter' => 'auth'], static function ($routes) {

        // Dashboard
        $routes->get('/', 'DashboardController::index', ['as' => 'crm.dashboard']);

        // Angajati - CRUD
        // Urmează un model RESTful mai detaliat
        $routes->get('angajati', 'AngajatiController::index', ['as' => 'crm.angajati']);
        $routes->get('angajati/form', 'AngajatiController::form', ['as' => 'crm.angajati.new']); // Afișează formularul gol
        $routes->get('angajati/form/(:num)', 'AngajatiController::form/$1', ['as' => 'crm.angajati.edit']); // Afișează formularul pentru editare
        $routes->post('angajati/save', 'AngajatiController::save', ['as' => 'crm.angajati.save']); // Salvează (creează sau actualizează)

        // Aici se vor adăuga rutele pentru:
        // - Clienti
        // - Proiecte
        // - Pontaj
        // - Rapoarte
        // - Concedii

    // }); // Sfârșitul grupului protejat
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

