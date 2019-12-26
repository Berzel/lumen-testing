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

use Illuminate\Support\Facades\Route;

$router->group(['prefix' => 'v1/users'], function () use ($router) {
    $router->get('/', [
        'as' => 'users.index',
        'users' => 'UserController@index'
    ]);

    $router->delete('{id}', [
        'as' => 'users.delete',
        'uses' => 'UserController@delete'
    ]);

    $router->put('{id}', [
        'as' => 'users.update',
        'uses' => 'UserController@update'
    ]);

    $router->post('/', [
        'as' => 'users.create',
        'uses' => 'UserController@store'
    ]);
});
