<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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


$routes->get('/quickquote/printquickquote', 'Quickquote::printquickquote');

$routes->post('backup', 'BackupController::dbbackup');

$routes->post('userlogin', 'UserController::userlogin');

$routes->get('/', 'Login::index'); // Ensure 'Login' matches your controller class name
// Replace 'Auth' with your actual controller name



// $routes->get('account/getledger/(:num)', 'Account::getLedger/$1');

$routes->get('account/getLedgerByFY/(:num)', 'Account::getLedgerByFY/$1');


/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('savedata', 'Crud::savedata');
$routes->get('crud/edit/(:num)', 'Crud::edit/$1');
$routes->post('crud/update', 'Crud::update');
$routes->get('crud/showdata', 'Home::index');


$routes->group('client', function($routes) {
    $routes->get('home', 'Client::index', ['as' => 'client.home']);       // Client home page
    $routes->get('', 'Client::showdata',['as' => 'client.manageclients']);                                 // Show data route
    // $routes->get('insert', 'Client::insert');
    $routes->post('manageclients/insert', 'Client::insert');  // Use POST for form submission
                             // Insert data route
    $routes->get('manageclients/edit/(:num)', 'Client::edit/$1');
    $routes->get('manageclients/delete/(:num)', 'Client::delete/$1');   //represents get method url has num para so
    $routes->post('manageclients/update', 'Client::update');                   // represents post method
    $routes->get('manageclients/viewclientinfo/(:any)', 'Client::viewclientinfo/$1');

});


$routes->group('supplier', function($routes) {
    $routes->get('home', 'supplier::index', ['as' => 'supplier.managesupplier']);       // Client home page
    $routes->get('', 'supplier::showdata',['as' => 'supplier.managesupplier']);                                 // Show data route
    // $routes->get('insert', 'Client::insert');
    $routes->post('managesupplier/insert', 'supplier::insert');  // Use POST for form submission
                             // Insert data route
    $routes->get('managesupplier/edit/(:num)', 'supplier::edit/$1');
    $routes->get('managesupplier/delete/(:num)', 'supplier::delete/$1');   //represents get method url has num para so
    $routes->post('managesupplier/update', 'supplier::update');                   // represents post method
});


$routes->group('product', function($routes) {
    $routes->get('home', 'product::index', ['as' => 'product.manageproduct']);       // Client home page
    $routes->get('', 'product::showdata',['as' => 'product.manageproduct']);                                 // Show data route
    // $routes->get('insert', 'Client::insert');
    $routes->post('manageproduct/insert', 'product::insert');  // Use POST for form submission
                             // Insert data route
    $routes->get('manageproduct/edit/(:num)', 'product::edit/$1');
    $routes->get('manageproduct/delete/(:num)', 'product::delete/$1');   //represents get method url has num para so
    $routes->post('manageproduct/update', 'product::update');                   // represents post method
});


$routes->group('purchaseinv', function($routes) {
    $routes->get('home', 'purchaseinv::index', ['as' => 'purchaseinv.genpurchaseinv']);       // Client home page
    $routes->get('', 'purchaseinv::showdata',['as' => 'purchaseinv.genpurchaseinv']);                                 // Show data route
    // $routes->get('insert', 'Client::insert');
    $routes->post('purchaseinv/insert', 'purchaseinv::insert');  // Use POST for form submission
                                                     // Insert data route
    $routes->get('purchaseinv/edit/(:num)', 'purchaseinv::edit/$1');
    $routes->post('purchaseinv/delete/(:num)', 'purchaseinv::delete/$1');   //represents get method url has num para so
    $routes->post('purchaseinv/update', 'purchaseinv::update');                   // represents post method
});


// app/Config/Routes.php

$routes->set404Override('App\Controllers\Errors::show404');

// $routes->group('account', function($routes) {
//     $routes->get('home', 'account::index', ['as' => 'account.home']);       // Client home page
//     $routes->get('', 'account::showdata',['as' => 'account.manageaccounts']);                                 // Show data route
//     // $routes->get('insert', 'Client::insert');
//     $routes->post('account/insert', 'account::insert');  // Use POST for form submission
//                              // Insert data route
//     $routes->get('account/edit/(:num)', 'account::edit/$1');
//     $routes->get('account/delete/(:num)', 'account::delete/$1');   //represents get method url has num para so
//     $routes->post('account/update', 'account::update');                   // represents post method
// });
$routes->group('account', function($routes) {
    $routes->get('home', 'Account::index', ['as' => 'account.home']);            // Client home page
    $routes->get('', 'Account::showdata', ['as' => 'account.manageaccounts']);    // Show data route
        //$routes->post('insert', 'Account::insert');    
    $routes->post('insert', 'Account::insert');                                  // Insert data route (POST method)
    $routes->get('edit/(:num)', 'Account::edit/$1');                             // Edit route with ID parameter
    $routes->get('delete/(:num)', 'Account::delete/$1');                         // Delete route with ID parameter (GET method)
    $routes->post('update', 'Account::update'); 

    $routes->get('account/getledger/(:num)', 'Account::getledger/$1');
                                 // Update data route (POST method)
});


$routes->group('transaction', function($routes) {
    $routes->get('home', 'transaction::index', ['as' => 'transaction.home']);            // Client home page
    $routes->get('', 'transaction::showdata', ['as' => 'transaction.managetransaction']);    // Show data route
    $routes->post('insert', 'transaction::insert');                                  // Insert data route (POST method)
    $routes->get('edit/(:segment)', 'transaction::edit/$1');                             // Edit route with ID parameter
    $routes->get('delete/(:segment)', 'transaction::delete/$1');                         // Delete route with ID parameter (GET method)
    $routes->post('update', 'transaction::update'); 

   // $routes->get('transaction/getledger/(:num)', 'Account::getledger/$1');
                                 // Update data route (POST method)
});


//$routes->get('quote/printquote/(:any)', 'Quote::printquote/$1');
$routes->get('quote/printquote', 'Quote::printquote');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
