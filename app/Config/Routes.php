<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('customer', 'Customer::index');
    $routes->get('produk', 'Produk::index');
    $routes->get('invoice', 'Invoice::index');
    $routes->get('report', 'ReportController::index');
});

$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::doRegister');

// $routes->get('customer', 'Customer::index');
$routes->get('customer/create', 'Customer::create');
$routes->post('customer/store', 'Customer::store');
$routes->get('customer/edit/(:num)', 'Customer::edit/$1');
$routes->post('customer/update/(:num)', 'Customer::update/$1');
$routes->get('customer/delete/(:num)', 'Customer::delete/$1');

// $routes->get('produk', 'Produk::index');
$routes->get('produk/create', 'Produk::create');
$routes->post('produk/store', 'Produk::store');
$routes->get('produk/edit/(:num)', 'Produk::edit/$1');
$routes->post('produk/update/(:num)', 'Produk::update/$1');
$routes->get('produk/delete/(:num)', 'Produk::delete/$1');

// $routes->get('invoice', 'Invoice::index');
$routes->get('invoice/create', 'Invoice::create');
$routes->post('invoice/store', 'Invoice::store');
$routes->get('invoice/edit/(:num)', 'Invoice::edit/$1');
$routes->post('invoice/update/(:num)', 'Invoice::update/$1');
$routes->post('invoice/delete/(:num)', 'Invoice::delete/$1');

// $routes->get('/report', 'ReportController::index');
$routes->get('/report/pdf', 'ReportController::pdf');
$routes->get('/report/excel', 'ReportController::excel');




