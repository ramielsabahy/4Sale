<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/check-availability', 'TableController@checkAvailability');
$router->post('/reserve-table', 'ReservationController@reserveTable');
$router->get('/list-meals', 'MealsController@listMeals');
$router->post('/order', 'OrderController@order');
$router->get('/invoice', 'OrderController@invoice');
