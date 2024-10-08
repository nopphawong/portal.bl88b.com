<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes @dm1nCent
 */

// PAGE
$routes->get('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('detect/(:segment)', 'Auth::detect/$1');
$routes->get('forbidden', 'Auth::forbidden');

$pageauth = ['filter' => \App\Filters\PageAuth::class];
$routes->get('/', 'Page::index', $pageauth);
$routes->get('forbidden', 'Auth::forbidden', $pageauth);
// $routes->get('agent/info', 'Page::agent_info', $pageauth);
// $routes->get('banner', 'Page::banner', $pageauth);
// $routes->get('wheel/info', 'Page::wheel_info', $pageauth);
// $routes->get('checkin/info', 'Page::checkin_info', $pageauth);
// $routes->get('webuser', 'Page::webuser', $pageauth);

$pageagent = ['filter' => \App\Filters\PageAgent::class];
$routes->get('channel', 'Page::channel', $pageagent);
$routes->get('lotto', 'Page::Lotto', $pageagent);
$routes->get('admin', 'Page::admin', $pageagent);
$routes->get('agent/info', 'Page::agent_info', $pageagent);
$routes->get('banner', 'Page::banner', $pageagent);
$routes->get('wheel/info', 'Page::wheel_info', $pageagent);
$routes->get('checkin/info', 'Page::checkin_info', $pageagent);
$routes->get('webuser', 'Page::webuser', $pageagent);
$routes->get('user/point', 'Page::user_point', $pageagent);

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
$routes->post('banner/delete', 'serv\Banner::record_delete');

$routes->post('wheel/add', 'serv\Wheel::add', $servauth);
$routes->post('wheel/list', 'serv\Wheel::list', $servauth);
$routes->post('wheel/first', 'serv\Wheel::first', $servauth);
$routes->post('wheel/add', 'serv\Wheel::add', $servauth);
$routes->post('wheel/info', 'serv\Wheel::info', $servauth);
$routes->post('wheel/info/update', 'serv\Wheel::info_update', $servauth);

$routes->post('segment/add', 'serv\Segment::add', $servauth);
$routes->post('segment/list', 'serv\Segment::list', $servauth);
$routes->post('segment/list/update', 'serv\Segment::list_update', $servauth);
$routes->post('segment/shuffle', 'serv\Segment::shuffle', $servauth);
$routes->post('segment/info', 'serv\Segment::info', $servauth);
$routes->post('segment/info/update', 'serv\Segment::info_update', $servauth);

$routes->post('checkin/add', 'serv\Checkin::add', $servauth);
$routes->post('checkin/list', 'serv\Checkin::list', $servauth);
$routes->post('checkin/first', 'serv\Checkin::first', $servauth);
$routes->post('checkin/add', 'serv\Checkin::add', $servauth);
$routes->post('checkin/info', 'serv\Checkin::info', $servauth);
$routes->post('checkin/info/update', 'serv\Checkin::info_update', $servauth);

$routes->post('progress/add', 'serv\Progress::add', $servauth);
$routes->post('progress/list', 'serv\Progress::list', $servauth);
$routes->post('progress/info', 'serv\Progress::info', $servauth);
$routes->post('progress/info/update', 'serv\Progress::info_update', $servauth);

// $routes->post('user/list', 'serv\User::list', $servauth);
// $routes->post('user/add', 'serv\User::add', $servauth);
$routes->post('user/info', 'serv\User::info', $servauth);
$routes->post('user/info/update', 'serv\User::info_update', $servauth);
$routes->post('user/inactive', 'serv\User::status_inactive', $servauth);
$routes->post('user/active', 'serv\User::status_active', $servauth);
$routes->post('user/delete', 'serv\User::record_delete');


$servagent = ['filter' => \App\Filters\ServAgent::class];
$routes->post('user/admin/list', 'serv\User::list/admin', $servagent);
$routes->post('user/admin/add', 'serv\User::add/admin', $servagent);

$routes->post('webuser/list', 'serv\Webuser::list', $servagent);
$routes->post('webuser/add', 'serv\Webuser::add', $servagent);
$routes->post('webuser/import', 'serv\Webuser::import', $servagent);
$routes->post('webuser/toggle/(:segment)/(:num)', 'serv\Webuser::toggle/$1/$2', $servagent);
$routes->post('webuser/remove/(:segment)', 'serv\Webuser::remove/$1', $servagent);

$routes->post('channel/list', 'serv\Channel::list', $servagent);
$routes->post('channel/save', 'serv\Channel::save', $servagent);
$routes->post('channel/info', 'serv\Channel::info', $servagent);
$routes->post('channel/delete', 'serv\Channel::remove', $servagent);
$routes->post('channel/active/(:num)', 'serv\Channel::active/$1', $servagent);

$routes->post('lotto/list', 'serv\Lotto::list', $servagent);
$routes->post('lotto/info', 'serv\Lotto::info', $servagent);
$routes->post('lotto/save', 'serv\Lotto::save', $servagent);
$routes->post('lotto/bing/update', 'serv\Lotto::bingo_update', $servagent);
$routes->post('lotto/remove/(:num)', 'serv\Lotto::remove/$1', $servagent);
$routes->post('lotto/active/(:segment)/(:num)', 'serv\Lotto::active/$1/$2', $servagent);

$routes->post('lotto/type/list', 'serv\Lotto::type_list', $servagent);

$routes->post('lotto/number/list', 'serv\Lotto::number_list', $servagent);
$routes->post('lotto/number/add', 'serv\Lotto::number_add', $servagent);
$routes->post('lotto/number/remove/(:num)', 'serv\Lotto::number_remove/$1', $servagent);
$routes->post('lotto/number/active/(:segment)/(:num)', 'serv\Lotto::number_active/$1/$2', $servagent);

$routes->post('user/point/list', 'serv\User::point_list', $servagent);
$routes->post('user/point/save', 'serv\User::point_save', $servagent);
$routes->post('user/point/remove/(:num)', 'serv\User::point_remove/$1', $servagent);
$routes->post('user/point/active/(:segment)/(:num)', 'serv\User::point_active/$1/$2', $servagent);

$servmaster = ['filter' => \App\Filters\ServMaster::class];
$routes->post('agent/list', 'serv\Agent::list', $servmaster);
$routes->post('agent/add', 'serv\Agent::add', $servmaster);
$routes->post('agent/config', 'serv\Agent::config', $servmaster);
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
        $routes->post('config', 'api\Agent::config');
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
        $routes->post('delete', 'api\Banner::record_delete');
    });

    $routes->group('user', static function ($routes) {
        // api/user/{{ function }}
        $routes->post('add', 'api\User::add');
        $routes->post('list', 'api\User::list');
        $routes->post('info', 'api\User::info');
        $routes->post('info/update', 'api\User::info_update');
        $routes->post('inactive', 'api\User::status_inactive');
        $routes->post('active', 'api\User::status_active');
        $routes->post('delete', 'api\User::record_delete');
    });

    $routes->group('wheeldaily', static function ($routes) {
        // api/wheeldaily/{{ function }}
        $routes->post('list', 'api\WheelDaily::list');
        $routes->post('list/usable', 'api\WheelDaily::list/usable');
        $routes->post('list/claimable', 'api\WheelDaily::list/claimable');
        $routes->post('list/history', 'api\WheelDaily::list/history');
        $routes->post('info', 'api\WheelDaily::info');
        $routes->post('addable', 'api\WheelDaily::addable');
        $routes->post('add', 'api\WheelDaily::add');
        $routes->post('roll', 'api\WheelDaily::roll');
        $routes->post('claim', 'api\WheelDaily::claim');
        $routes->post('unclaim', 'api\WheelDaily::unclaim');
    });
    $routes->group('checkindaily', static function ($routes) {
        // api/checkindaily/{{ function }}
        $routes->post('list', 'api\CheckinDaily::list');
        $routes->post('list/claimable', 'api\CheckinDaily::list/claimable');
        $routes->post('list/history', 'api\CheckinDaily::list/history');
        $routes->post('info', 'api\CheckinDaily::info');
        $routes->post('usable', 'api\CheckinDaily::usable');
        $routes->post('add', 'api\CheckinDaily::add');
        $routes->post('claim', 'api\CheckinDaily::claim');
        $routes->post('unclaim', 'api\CheckinDaily::unclaim');
    });

    $routes->group('wheel', static function ($routes) {
        // api/wheel/{{ function }}
        $routes->post('add', 'api\Wheel::add');
        $routes->post('info', 'api\Wheel::info');
        $routes->post('info/update', 'api\Wheel::info_update');
        $routes->post('list', 'api\Wheel::list');
        $routes->post('first', 'api\Wheel::first');
        $routes->post('roll', 'api\Wheel::roll');
    });
    $routes->group('segment', static function ($routes) {
        // api/segment/{{ function }}
        $routes->post('add', 'api\Segment::add');
        $routes->post('list', 'api\Segment::list');
        $routes->post('shuffle', 'api\Segment::shuffle');
        $routes->post('info', 'api\Segment::info');
        $routes->post('info/update', 'api\Segment::info_update');
    });

    $routes->group('checkin', static function ($routes) {
        // api/checkin/{{ function }}
        $routes->post('add', 'api\Checkin::add');
        $routes->post('info', 'api\Checkin::info');
        $routes->post('info/update', 'api\Checkin::info_update');
        $routes->post('list', 'api\Checkin::list');
        $routes->post('first', 'api\Checkin::first');
    });
    $routes->group('progress', static function ($routes) {
        // api/progress/{{ function }}
        $routes->post('add', 'api\Progress::add');
        $routes->post('list', 'api\Progress::list');
        $routes->post('info', 'api\Progress::info');
        $routes->post('info/update', 'api\Progress::info_update');
    });
    $routes->group('webuser', static function ($routes) {
        // api/Webuser/{{ function }}
        $routes->post('register', 'api\Webuser::register');
        $routes->post('unlink', 'api\Webuser::unlink');
        $routes->post('checkup', 'api\Webuser::checkup');
    });
    $routes->group('channel', static function ($routes) {
        // api/channel/{{ function }}
        $routes->post('list', 'api\Channel::list');
    });
    $routes->group('lotto', static function ($routes) {
        // api/channel/{{ function }}
        $routes->post('running_number_master/(:segment)', 'api\Lotto::running_number_master/$1');
        $routes->post('list', 'api\Lotto::list');
        $routes->post('info', 'api\Lotto::info');
        $routes->post('history', 'api\Lotto::history');
        $routes->post('point', 'api\Lotto::point');
        $routes->post('number/list', 'api\Lotto::number_list');
        $routes->post('number/buy', 'api\Lotto::number_buy');
    });

    $routes->group('bl88', static function ($routes) {
        // api/bl88/{{ function }}
        $routes->post('test', 'api\Bl88::test', ['filter' => \App\Filters\Cors::class]);
        $routes->post('login', 'api\Bl88::login', ['filter' => \App\Filters\Cors::class]);
        $routes->post('register', 'api\Bl88::register', ['filter' => \App\Filters\Cors::class]);
        $routes->post('bank/list', 'api\Bl88::bank_list', ['filter' => \App\Filters\Cors::class]);
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
