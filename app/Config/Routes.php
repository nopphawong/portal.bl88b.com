<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes @dm1nCent
 */

// PAGE
$routes->get('login', 'Page::login');
$routes->get('logout', 'Page::logout');
$routes->get('detect/(:segment)', 'Page::detect/$1');

$pageauth = ['filter' => \App\Filters\PageAuth::class];
$routes->get('/', 'Page::index', $pageauth);
$routes->get('forbidden', 'Page::forbidden', $pageauth);
$routes->get('agent/info', 'Page::agent_info', $pageauth);
$routes->get('banner', 'Page::banner', $pageauth);

$pageagent = ['filter' => \App\Filters\PageAgent::class];
$routes->get('admin', 'Page::admin', $pageagent);

$pagemaster = ['filter' => \App\Filters\PageMaster::class];
$routes->get('agent', 'Page::agent', $pagemaster);
$routes->get('agent/(:segment)/(:segment)/(:segment)', 'Page::agent_view/$1/$2/$3', $pagemaster);

// SERV
$routes->get('unauthen', 'serv\Auth::unauthen');
$routes->get('deny', 'serv\Auth::deny');

$routes->post('auth/login', 'serv\Auth::login');

$servauth = ['filter' => \App\Filters\ServAuth::class];
$routes->post('agent/info', 'serv\Agent::info', $servauth);
$routes->post('agent/info/update', 'serv\Agent::info_update', $servauth);

$routes->post('banner/list', 'serv\Banner::list', $servauth);
$routes->post('banner/add', 'serv\Banner::add', $servauth);
$routes->post('banner/info', 'serv\Banner::info', $servauth);
$routes->post('banner/info/update', 'serv\Banner::info_update', $servauth);
$routes->post('banner/inactive', 'serv\Banner::status_inactive', $servauth);
$routes->post('banner/active', 'serv\Banner::status_active', $servauth);

// $routes->post('user/list', 'serv\User::list', $servauth);
// $routes->post('user/add', 'serv\User::add', $servauth);
$routes->post('user/info', 'serv\User::info', $servauth);
$routes->post('user/info/update', 'serv\User::info_update', $servauth);
$routes->post('user/inactive', 'serv\User::status_inactive', $servauth);
$routes->post('user/active', 'serv\User::status_active', $servauth);

$servagent = ['filter' => \App\Filters\ServAgent::class];
$routes->post('user/admin/list', 'serv\User::list/admin', $servagent);
$routes->post('user/admin/add', 'serv\User::add/admin', $servagent);

$servmaster = ['filter' => \App\Filters\ServMaster::class];
$routes->post('agent/list', 'serv\Agent::list', $servmaster);
$routes->post('agent/add', 'serv\Agent::add', $servmaster);
$routes->post('agent/active', 'serv\Agent::status_active', $servmaster);
$routes->post('agent/inactive', 'serv\Agent::status_inactive', $servmaster);

// API
$routes->group('api', static function ($routes) {

    $routes->group('auth', static function ($routes) {
        // api/auth/{{ function }}
        $routes->post('detect', 'api\Auth::detect');
        $routes->post('login', 'api\Auth::login');
    });

    $routes->group('agent', static function ($routes) {
        // api/agent/{{ function }}
        $routes->post('add', 'api\Agent::add');
        $routes->post('list', 'api\Agent::list');
        $routes->post('info', 'api\Agent::info');
        $routes->post('info/update', 'api\Agent::info_update');
        $routes->post('active', 'api\Agent::status_active');
        $routes->post('inactive', 'api\Agent::status_inactive');
    });

    $routes->group('banner', static function ($routes) {
        // api/banner/{{ function }}
        $routes->post('add', 'api\Banner::add');
        $routes->post('list', 'api\Banner::list');
        $routes->post('list/actived', 'api\Banner::list/1');
        $routes->post('info', 'api\Banner::info');
        $routes->post('info/update', 'api\Banner::info_update');
        $routes->post('inactive', 'api\Banner::status_inactive');
        $routes->post('active', 'api\Banner::status_active');
    });

    $routes->group('user', static function ($routes) {
        // api/user/{{ function }}
        $routes->post('add', 'api\User::add');
        $routes->post('list', 'api\User::list');
        $routes->post('info', 'api\User::info');
        $routes->post('info/update', 'api\User::info_update');
        $routes->post('inactive', 'api\User::status_inactive');
        $routes->post('active', 'api\User::status_active');
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
