<?php
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

// Firebase get data
$app->get('/v1/data/root', 'FirebaseController@firebaseRoot');
$app->get('/v1/data/{path}/index', 'FirebaseController@firebaseIndex');

// Firebase watchdog
$app->get('/v1/data/watch', 'watchdogController@');

$app->get('/v1/watchdog/{path:[a-zA-Z0-9\-\/]+}', 'watchdogController@readFromTxt');

$app->post('/posts', 'watchdogController@setContentOnFirebase');
