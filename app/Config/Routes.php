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
// $routes->setDefaultController('Home');
$routes->setDefaultController('Users');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
$routes->get('/', 'Users::index', ['filter' => 'noauth']);
$routes->get('logout', 'Users::logout');
$routes->match(['get', 'post'], 'register', 'Users::register', ['filter' => 'noauth']);
$routes->match(['get', 'post'], 'profile', 'Users::profile', ['filter' => 'auth']);
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Suppliers
$routes->match(['get', 'post'], 'suppliers/add', 'Suppliers::add_suppliers', ['filter' => 'auth']);
$routes->get('suppliers', 'Suppliers::index', ['filter' => 'auth']);
$routes->get('suppliers/(:num)', 'Suppliers::view_supplier/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'suppliers/(:num)/edit', 'Suppliers::edit_supplier/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'suppliers/(:num)/delete', 'Suppliers::delete_supplier/$1', ['filter' => 'auth']);

// Inventory
$routes->get('products', 'Products::index', ['filter' => 'auth']);
$routes->get('products/(:num)', 'Products::view_product/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'products/add', 'Products::add_product', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'products/(:num)/edit', 'Products::edit_product/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'products/(:num)/delete', 'Products::delete_product/$1', ['filter' => 'auth']);

// Sales
$routes->get('sales', 'Sales::index', ['filter' => 'auth']);
$routes->get('sales/(:num)', 'Sales::view_sales_order/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'sales/add', 'Sales::add_sales', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'sales/(:num)/release', 'Sales::confirm_release/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'sales/(:num)/delete', 'Sales::delete_sales/$1', ['filter' => 'auth']);

// Purchases
$routes->get('incoming', 'Incoming::index', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'incoming/add', 'Incoming::add_purchase', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'incoming/(:num)/received', 'Incoming::received/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'incoming/(:num)/delete', 'Incoming::delete_purchase/$1', ['filter' => 'auth']);

// Brands
$routes->get('brands', 'Brands::index', ['filter' => 'auth']);
$routes->get('brands/(:num)', 'Brands::view_brand/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'brands/add', 'Brands::add_brand', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'brands/(:num)/edit', 'Brands::edit_brand/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], 'brands/(:num)/delete', 'Brands::delete_brand/$1', ['filter' => 'auth']);

//Export


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
