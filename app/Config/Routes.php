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
$routes->setAutoRoute(true);
$routes->set404Override('\\App\\Controllers\\Errors::show404');
// --------------------------------------------------------------------
// Installer Wizard (UI based on jmrashed/php-installer)
// --------------------------------------------------------------------
$routes->get('install', 'Install::index');
$routes->post('install', 'Install::submit');
$routes->get('install/(:any)', 'Install::index/$1');
$routes->post('install/(:any)', 'Install::submit/$1');

$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/dashboard2', 'Dashboard::Dashboard2');
$routes->get('login', 'Login::index');
$routes->get('login/logout', 'Login::logout');
$routes->get('account/manageaccounts', 'Account::manageaccounts');
$routes->get('account/demo', 'Account::demo');
$routes->get('client/manageclients', 'Client::manageclients');
$routes->get('client/viewclientinfo/(:num)', 'Client::viewclientinfo/$1');
$routes->get('client/viewclientinfo/(:any)', 'Client::viewclientinfo/$1');
$routes->get('product/manageproducts', 'Product::manageproducts');
$routes->get('product/viewproductinfo/(:num)', 'Product::viewproductinfo/$1');
$routes->get('product/viewproductinfo/(:any)', 'Product::viewproductinfo/$1');
$routes->get('supplier/managesupplier', 'supplier::managesupplier');
$routes->get('supplier/viewsupplierinfo/(:num)', 'supplier::viewsupplierinfo/$1');
$routes->get('supplier/viewsupplierinfo/(:any)', 'supplier::viewsupplierinfo/$1');
$routes->get('purchaseinv/genpurchaseinv', 'Purchaseinv::genpurchaseinv');
$routes->get('purchaseinv/showdata', 'Purchaseinv::showdata');
$routes->get('quickquote', 'Quickquote::index');
$routes->get('quote/genquote', 'Quote::genquote');
$routes->get('quote/showquotedata', 'Quote::showquotedata');
$routes->get('proinv/showprodata', 'Proinv::showprodata');
$routes->get('taxinv/showtaxdata', 'Taxinv::showtaxdata');
$routes->get('transaction/managetransaction', 'Transaction::managetransaction');
$routes->get('profile/settings', 'Profile::settings');
$routes->post('profile/updateData', 'Profile::updateData');
$routes->post('profile/updateData2', 'Profile::updateData2');
$routes->post('profile/updateData3', 'Profile::updateData3');
$routes->post('profile/updateBankDetails', 'Profile::updateBankDetails');
$routes->post('profile/uploadProductImage', 'Profile::uploadProductImage');
$routes->post('profile/uploadProductImage2', 'Profile::uploadProductImage2');
$routes->post('profile/dbbackup', 'Profile::dbbackup');
$routes->post('profile/restoreDB', 'Profile::restoreDB');
$routes->post('layoutsettings/save', 'Layoutsettings::save');
$routes->get('proinv/genproinv', 'Proinv::genproinv');
$routes->get('proinv/proreport', 'Proinv::proreport');
$routes->get('proinv/proitemreport', 'Proinv::proitemreport');
$routes->get('proinv/loadinvoices', 'Proinv::loadInvoices');
$routes->get('proinv/loaditems', 'Proinv::loaditems');
$routes->get('proinv/getclient', 'Proinv::getclient');
$routes->get('proinv/getproducts', 'Proinv::getproducts');
$routes->get('proinv/getproducthsn', 'Proinv::getproducthsn');
$routes->get('taxinv/gentaxinv', 'Taxinv::gentaxinv');
$routes->get('taxinv/salereport', 'Taxinv::salereport');
$routes->get('taxinv/saleitemreport', 'Taxinv::saleitemreport');
$routes->get('taxinv/salehsnreport', 'Taxinv::saleHsnreport');
$routes->get('taxinv/saleHsnreport', 'Taxinv::saleHsnreport');
$routes->get('taxinv/getclient', 'Taxinv::getclient');
$routes->get('taxinv/getproducts', 'Taxinv::getproducts');
$routes->get('taxinv/loadinvoices', 'Taxinv::loadInvoices');
$routes->get('taxinv/loaditems', 'Taxinv::loaditems');
$routes->get('taxinv/loadhsn', 'Taxinv::loadhsn');
$routes->get('purchaseinv/purchasereport', 'Purchaseinv::purchasereport');
$routes->get('purchaseinv/purchaseitemreport', 'Purchaseinv::purchaseitemreport');
$routes->get('purchaseinv/purhsnreport', 'Purchaseinv::purHsnreport');
$routes->get('purchaseinv/purHsnreport', 'Purchaseinv::purHsnreport');
$routes->get('purchaseinv/getsupplier', 'Purchaseinv::getsupplier');
$routes->get('purchaseinv/getproducts', 'Purchaseinv::getproducts');
$routes->get('purchaseinv/loadinvoices', 'Purchaseinv::loadInvoices');
$routes->get('purchaseinv/loaditems', 'Purchaseinv::loaditems');
$routes->get('purchaseinv/loadhsn', 'Purchaseinv::loadhsn');
$routes->get('quickquote/quickquotereport', 'Quickquote::quickquotereport');
$routes->get('quickquote/loadinvoices', 'Quickquote::loadInvoices');
$routes->get('quickquote/getclient', 'Quote::getclient');
$routes->get('quote/quotereport', 'Quote::quotereport');
$routes->get('quote/quoteitemreport', 'Quote::quoteitemreport');
$routes->get('quote/loadinvoices', 'Quote::loadInvoices');
$routes->get('quote/loaditems', 'Quote::loaditems');
$routes->get('quote/getclient', 'Quote::getclient');
$routes->get('quote/getproducts', 'Quote::getproducts');

$routes->post('client/checkGst', 'Client::checkGst');

$routes->post('/transaction/checkDuplicate', 'TransactionController::checkDuplicate');

$routes->get('/quickquote/printquickquote', 'Quickquote::printquickquote');

$routes->post('backup', 'BackupController::dbbackup');

$routes->post('userlogin', 'UserController::userlogin');

$routes->get('/', 'Login::index'); // Ensure 'Login' matches your controller class name
// Replace 'Auth' with your actual controller name



$routes->post('client/checkGst', 'Client::checkGst');

$routes->post('/transaction/checkDuplicate', 'TransactionController::checkDuplicate');

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

    $routes->get('getledger/(:num)', 'Account::getledger/$1');
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
$routes->get('purchaseinv/printpurchaseinv', 'Purchaseinv::printpurchaseinv');
$routes->get('proinv/printproinv', 'Proinv::printproinv');
$routes->get('taxinv/printtaxinv', 'Taxinv::printtaxinv');
// ------------------------------------------------------------------
// AJAX endpoints used by Taxinv / Proinv list pages (MUST precede the 404 catch-alls,_else they hit the show404 wildcard,_the filters stop working)
// ------------------------------------------------------------------
$routes->get('taxinv/getyear', 'Taxinv::getyear');
$routes->get('proinv/getyear', 'Proinv::getyear');
$routes->post('taxinv/delete/(:segment)', 'Taxinv::delete/$1');
$routes->post('proinv/delete/(:segment)', 'Proinv::delete/$1');

// Transaction page AJAX (filters, bank details, client)
$routes->get('transaction/loadTransactions', 'Transaction::loadTransactions');
$routes->get('transaction/getBankDetails', 'Transaction::getBankDetails');
$routes->get('transaction/getclient', 'Transaction::getclient');

// Client / Product / Supplier / Account page AJAX (modal add/edit/delete/update/gst/next-id)
$routes->get('client/edit/(:num)', 'Client::edit/$1');
$routes->post('client/insert', 'Client::insert');
$routes->get('client/delete/(:num)', 'Client::delete/$1');
$routes->post('client/update', 'Client::update');
$routes->get('client/get_next_id', 'Client::get_next_id');
$routes->post('client/checkGST', 'Client::checkGst');
$routes->post('client/checkGstupdate', 'Client::checkGstupdate');

$routes->get('product/edit/(:num)', 'Product::edit/$1');
$routes->post('product/insert', 'Product::insert');
$routes->get('product/delete/(:num)', 'Product::delete/$1');
$routes->post('product/update', 'Product::update');
$routes->get('product/get_next_id', 'Product::get_next_id');
$routes->post('product/uploadproductimage', 'Product::uploadProductImage');
$routes->post('product/updateuploadproductimage', 'Product::updateuploadProductImage');

$routes->post('supplier/insert', 'Supplier::insert');
$routes->get('supplier/delete/(:num)', 'Supplier::delete/$1');
$routes->get('supplier/get_next_id', 'Supplier::get_next_id');

$routes->get('account/getclient', 'Account::getclient');
$routes->post('account/updateHidden', 'Account::updateHidden');
$routes->get('account/get_next_id', 'Account::get_next_id');

// Quote / Purchase Invoice list pages AJAX (fy dropdown + delete)
$routes->get('quote/getyear', 'Quote::getyear');
$routes->post('quote/delete/(:any)', 'Quote::delete/$1');
$routes->get('purchaseinv/getyear', 'Purchaseinv::getyear');
$routes->post('purchaseinv/delete/(:any)', 'Purchaseinv::delete/$1');

// Remaining Transaction page AJAX (query-param edit/delete + duplicate check)
$routes->get('transaction/edit', 'Transaction::edit');
$routes->get('transaction/delete', 'Transaction::delete');
$routes->post('transaction/checkDuplicateRecord', 'Transaction::checkDuplicateRecord');

// Invoice generation pages AJAX world save/insert - also unblocked by the 404 wildcards
$routes->post('proinv/insert', 'Proinv::insert');
$routes->post('purchaseinv/insert', 'Purchaseinv::insert');
$routes->get('purchaseinv/editpurchaseinv/(:any)', 'Purchaseinv::editpurchaseinv/$1');
$routes->post('quote/insert', 'Quote::insert');
$routes->post('taxinv/insert', 'Taxinv::insert');
$routes->post('taxinv/savedeliveryaddress', 'Taxinv::savedeliveryaddress');

$routes->post('taxinv/delete/(:segment)', 'Taxinv::delete/$1');
$routes->post('proinv/delete/(:segment)', 'Proinv::delete/$1');

$routes->get('client/edit/(:num)', 'Client::edit/$1');
$routes->get('client/delete/(:num)', 'Client::delete/$1');

$routes->get('product/edit/(:num)', 'Product::edit/$1');
$routes->get('product/delete/(:num)', 'Product::delete/$1');

$routes->get('supplier/delete/(:num)', 'Supplier::delete/$1');

$routes->post('quote/delete/(:any)', 'Quote::delete/$1');
$routes->post('purchaseinv/delete/(:any)', 'Purchaseinv::delete/$1');
$routes->get('client/(:any)', 'Errors::show404');
$routes->get('product/(:any)', 'Errors::show404');
$routes->get('supplier/(:any)', 'Errors::show404');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 * 
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.

 
 * You will have access to the $routes object within that file without
 * needing to reload it.

 
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
