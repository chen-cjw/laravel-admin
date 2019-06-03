<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/users', 'Admin\UserController');
    $router->resource('/consignment_sample', 'Lab\ConsignmentSampleController');
    $router->resource('/consignment_report', 'Lab\ConsignmentReportController');

    $router->get('/consignment_report/download', 'Lab\ConsignmentReportControllerr@download');

});
