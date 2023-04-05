<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// $routes->setAutoRoute(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');
$routes->get('dashboard', 'Dashboard::index', ['filter'=>'authGuard']);
$routes->group('inwards', ['filter'=>'authGuard'], static function($routes){
    $routes->get('rom', 'Inwards\Rom::index');
    $routes->post('rom', 'Inwards\Rom::save');
    $routes->get('ob', 'Inwards\OB::index');
    $routes->post('ob', 'Inwards\OB::save');
    // total mineral weight via ajax request
    $routes->get('rom/current-mweight', 'Inwards\Rom::currentMWeight');
    $routes->get('ob/current-mweight', 'Inwards\OB::currentMWeight');
});
$routes->group('production', ['filter'=>'authGuard'], static function($routes){
    $routes->get('screen', 'Production\Screen::index');
    $routes->post('screen', 'Production\Screen::save');
    $routes->get('crusher', 'Production\Crusher::index');
    $routes->post('crusher', 'Production\Crusher::save');
    $routes->get('chute', 'Production\Chute::index');
    $routes->post('chute', 'Production\Chute::save');
    $routes->get('tantra', 'Production\Tantra::index');
    $routes->post('tantra', 'Production\Tantra::save');
    $routes->get('mines', 'Production\Mines::index');
    $routes->post('mines', 'Production\Mines::save');
    // total mineral weight via ajax request
    $routes->get('screen/current-mweight', 'Production\Screen::currentMWeight');
    $routes->get('crusher/current-mweight', 'Production\Crusher::currentMWeight');
    $routes->get('chute/current-mweight', 'Production\Chute::currentMWeight');
    $routes->get('tantra/current-mweight', 'Production\Tantra::currentMWeight');
    $routes->get('mines/current-mweight', 'Production\Mines::currentMWeight');
});
$routes->group('return', ['filter'=>'authGuard'], static function($routes){
    $routes->get("/", 'Returns::index');
    $routes->get("list", 'Returns::returnList');
    $routes->post("list", 'Returns::returnList');
    $routes->put("list", 'Returns::returnList');
    $routes->get("alert", 'Returns::getAlertData');
    $routes->post("upload", 'Returns::uploadData');
    $routes->get("data", 'Returns::getReturnData');
});
$routes->group('client-info',  ['filter'=>'authGuard'], static function($routes){
    $routes->get('/', 'ClientInfo::index');
    $routes->get('client', 'ClientInfo::client');
    $routes->post('client', 'ClientInfo::client');
    $routes->put('client', 'ClientInfo::client');
    $routes->delete('client', 'ClientInfo::client');
});

$routes->group('dispatch', ['filter'=>'authGuard'], static function($routes){
    $routes->get('challan', 'Dispatch\Challan::index');
    $routes->post('challan', 'Dispatch\Challan::generate');
    $routes->group('ship-info', static function($routes){
        $routes->get('/', 'Dispatch\ShipInfo::index');
        $routes->get('ship', 'Dispatch\ShipInfo::ship');
        $routes->post('ship', 'Dispatch\ShipInfo::ship');
        $routes->put('ship', 'Dispatch\ShipInfo::ship');
        $routes->delete('ship', 'Dispatch\ShipInfo::ship');
        $routes->get('ship-list', 'Dispatch\ShipInfo::shipNameList');
    });
});

$routes->group('uploads', ['filter'=>'authGuard'], static function($routes){
    $routes->get('/(:any)', 'Resource::index/$1');
    $routes->get('clients/(:any)', 'Resource::client/$1');
});
$routes->get('logout', 'Auth::logout');

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
