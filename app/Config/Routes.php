<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */

$routes->get('login', 'Page::login');
$routes->get('logout', 'Page::logout');

$pageauth = ['filter' => 'pageauth'];
$routes->get('/', 'Page::index', $pageauth);
$routes->get('web/info', 'Page::web_info', $pageauth);

// SERV
$routes->post('auth/login', 'serv\Auth::login');

$servauth = ['filter' => 'servauth'];
$routes->post('web/info', 'serv\Web::info', $servauth);
$routes->post('web/info/update', 'serv\Web::info_update', $servauth);


// API
$routes->group('api/(:segment)', static function ($routes) {
    /*
        api/web/info                web info
        api/web/info/update         web info update
    */
    $routes->post('web/(:any)', 'api\Web::execute_path/$1/$2/$3');
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
