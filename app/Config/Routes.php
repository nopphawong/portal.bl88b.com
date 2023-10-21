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
$routes->group('api', static function ($routes) {
    /*
        api/web/info                web info
        api/web/info/update         web info update
    */
    $routes->post('web/(:any)', 'api\Web::execute_path/$1/$2/$3');
});
