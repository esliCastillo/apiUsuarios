<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/test', 'TestController::index');

//$routes->resource('Tareas', ['filter' => 'auth']);
$routes->post('/Fotografia/(:num)', 'Usuarios::updatepicture/$1', ['filter' => 'auth']);
$routes->post('/login', 'Usuarios::login');
$routes->get('/usuariospdf', 'Usuarios::generatepdf');
$routes->resource('Usuarios', ['filter' => 'auth']);

