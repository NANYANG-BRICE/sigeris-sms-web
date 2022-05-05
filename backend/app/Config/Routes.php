<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */




/* ==================== fonctionnalitées concernant l'authentification ==================== */

    $routes->post('SignIn', 'Authentification::authentification');
    $routes->post('Recover', 'Authentification::recover_password');
    $routes->post('Activate', 'Authentification::activate_account');



/* ==================== fonctionnalitées concernant les administrateurs ==================== */

    $routes->get('Getting_admin', 'Administrateur::select_all_administrateur');
    $routes->post('Create_admin', 'Administrateur::create_new_administrateur');
    $routes->post('Update_admin', 'Administrateur::update_administrateur');
    $routes->get('Countting_admin', 'Administrateur::select_count_administrateur');
    $routes->get('Get_admin/(:any)', 'Administrateur::select_one_administrateur/$1');
    $routes->get('Desable_admin/(:any)', 'Administrateur::desable_administrateur/$1');
    $routes->get('Enable_admin/(:any)', 'Administrateur::enable_administrateur/$1');
    $routes->get('Delete_admin/(:any)', 'Administrateur::delete_administrateur/$1');






















/*$routes->get('SelectOneUser/(:any)',    'Personnel::SelectOneUser/$1');
$routes->get('UpdateUserEtat/(:any)',    'Personnel::UpdateUserEtat/$1');
$routes->post('CreateUser',             'Personnel::CreateUser');
$routes->post('Authentification',             'Personnel::Authentification');*/


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
