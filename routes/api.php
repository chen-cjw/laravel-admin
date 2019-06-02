<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array']
], function ($api) {
    $api->get('user', 'UsersController@index')->name('api.user.index');
    $api->post('user', 'UsersController@store')->name('api.user.store');
    //手机号码登陆 phoneStore
    $api->post('phone_store', 'UsersController@phoneStore')->name('api.user.phoneStore');

});

