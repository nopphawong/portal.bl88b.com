<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes @dm1nCent
 */


// PAGE
$routes->get('login', 'Page::login');
$routes->get('logout', 'Page::logout');

$pageauth = ['filter' => 'pageauth'];
$routes->get('/', 'Page::index', $pageauth);
$routes->get('agent/info', 'Page::agent_info', $pageauth);
$routes->get('banner', 'Page::banner', $pageauth);

$pageagent = ['filter' => 'pageagent'];
$routes->get('admin', 'Page::admin', $pageagent);

// SERV
$routes->get('unauthen', 'serv\Auth::unauthen');
$routes->get('deny', 'serv\Auth::deny');

$routes->post('auth/login', 'serv\Auth::login');

$servauth = ['filter' => 'servauth'];
$routes->post('agent/info', 'serv\Agent::info', $servauth);
$routes->post('agent/info/update', 'serv\Agent::info_update', $servauth);

$routes->post('banner/list', 'serv\Banner::list', $servauth);
$routes->post('banner/add', 'serv\Banner::add', $servauth);
$routes->post('banner/info', 'serv\Banner::info', $servauth);
$routes->post('banner/info/update', 'serv\Banner::info_update', $servauth);
$routes->post('banner/remove', 'serv\Banner::remove', $servauth);
$routes->post('banner/reuse', 'serv\Banner::reuse', $servauth);

// $routes->post('user/list', 'serv\User::list', $servauth);
// $routes->post('user/add', 'serv\User::add', $servauth);
$routes->post('user/info', 'serv\User::info', $servauth);
$routes->post('user/info/update', 'serv\User::info_update', $servauth);
$routes->post('user/remove', 'serv\User::remove', $servauth);
$routes->post('user/reuse', 'serv\User::reuse', $servauth);

$servagent = ['filter' => 'servagent'];
$routes->post('user/admin/list', 'serv\User::list/admin', $servagent);
$routes->post('user/admin/add', 'serv\User::add/admin', $servagent);

// API
$routes->group('api', static function ($routes) {

    $routes->group('agent', static function ($routes) {
        // api/agent/{{ function }}
        $routes->post('add', 'api\Agent::add');
        $routes->post('list', 'api\Agent::list');
        $routes->post('info', 'api\Agent::info');
        $routes->post('info/update', 'api\Agent::info_update');
    });

    $routes->group('banner', static function ($routes) {
        // api/banner/{{ function }}
        $routes->post('add', 'api\Banner::add');
        $routes->post('list', 'api\Banner::list');
        $routes->post('info', 'api\Banner::info');
        $routes->post('info/update', 'api\Banner::info_update');
        $routes->post('remove', 'api\Banner::remove');
        $routes->post('reuse', 'api\Banner::reuse');
    });

    $routes->group('user', static function ($routes) {
        // api/user/{{ function }}
        $routes->post('add', 'api\User::add');
        $routes->post('list', 'api\User::list');
        $routes->post('info', 'api\User::info');
        $routes->post('info/update', 'api\User::info_update');
        $routes->post('remove', 'api\User::remove');
        $routes->post('reuse', 'api\User::reuse');
    });
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
