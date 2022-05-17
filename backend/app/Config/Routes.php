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

    $routes->get('Getting_admin',           'Administrateur::select_all_administrateur');
    $routes->get('Get_admin/(:any)',        'Administrateur::select_one_administrateur/$1');

    $routes->post('Create_admin',           'Administrateur::create_new_administrateur');
    $routes->post('Update_admin',           'Administrateur::update_administrateur');

    $routes->get('Desable_admin/(:any)',    'Administrateur::desable_administrateur/$1');
    $routes->get('Enable_admin/(:any)',     'Administrateur::enable_administrateur/$1');
    $routes->get('Delete_admin/(:any)',     'Administrateur::delete_administrateur/$1');
    

    $routes->get('Countting_admin',         'Administrateur::select_count_administrateur');
    $routes->post('Update_profil_admin',    'Administrateur::update_profile_administrateur');



/* ==================== fonctionnalitées concernant les classes ==================== */

    $routes->get('Getting_classe', 'Classes::select_all_classes');
    $routes->post('Create_classe', 'Classes::create_new_administrateur');
    $routes->post('Update_classe', 'Classes::update_administrateur');
    $routes->get('Countting_classe', 'Classes::select_count_administrateur');
    $routes->get('Get_classe/(:any)', 'Classes::select_one_administrateur/$1');
    $routes->get('Desable_classe/(:any)', 'Classes::desable_administrateur/$1');
    $routes->get('Enable_classe/(:any)', 'Classes::enable_administrateur/$1');
    $routes->get('Delete_classe/(:any)', 'Classes::delete_administrateur/$1');










/* ==================== fonctionnalitées concernant les étudiants ==================== */

    $routes->get('Getting_student',            'Etudiants::select_all_students');
    $routes->get('Get_student/(:any)',         'Etudiants::select_one_student/$1');
    $routes->post('Create_student',            'Etudiants::create_new_student');
    $routes->post('Update_student',            'Etudiants::update_student');
    $routes->get('Desable_student/(:any)',     'Etudiants::desable_student/$1');
    $routes->get('Enable_student/(:any)',      'Etudiants::enable_student/$1');
    $routes->get('Delete_student/(:any)',      'Etudiants::delete_student/$1');
    $routes->get('Countting_student',          'Etudiants::custom_count_all_about_students');
    $routes->get('Print_student_list',         'Etudiants::print_pdf_student_list');
    $routes->get('Print_report_student_list',  'Etudiants::print_pdf_student_report');
    
    










/* ==================== fonctionnalitées concernant les enseignants ==================== */

    $routes->get('Select_all_teachers',                 'Enseignants::select_all_teachers');
    $routes->get('Select_one_teacher/(:any)',           'Enseignants::select_one_teacher/$1');
    $routes->post('Create_one_teacher',                 'Enseignants::create_one_new_teacher');
    $routes->post('Update_specify_teacher',             'Enseignants::update_specify_teacher');
    $routes->post('Desable_teacher/(:any)',             'Etudiants::desable_teacher/$1');
    

    $routes->get('Enable_student/(:any)',      'Etudiants::enable_student/$1');
    $routes->get('Delete_student/(:any)',      'Etudiants::delete_student/$1');
    $routes->get('Countting_student',          'Etudiants::custom_count_all_about_students');
    $routes->get('Print_student_list',         'Etudiants::print_pdf_student_list');
    $routes->get('Print_report_student_list',  'Etudiants::print_pdf_student_report');
    
    













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
