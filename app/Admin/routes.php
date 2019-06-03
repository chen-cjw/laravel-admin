<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::get('/admin/customer_sendhis', 'App\Admin\Controllers\Lab\CustomerSendhisController@index');// 2、查询待发送消息接口

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/consignment_report/download', 'Lab\ConsignmentReportController@download');

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/users', 'Admin\UserController');
    $router->get('/customer/add_customer', 'Lab\CustomerController@addCustomerIndex');// 新增记录接口
    $router->post('/customer/add_customer', 'Lab\CustomerController@addCustomer');// 新增记录接口
    $router->resource('/consignment_sample', 'Lab\ConsignmentSampleController');
    $router->resource('/consignment_report', 'Lab\ConsignmentReportController');
    $router->resource('/consignment_checkitem', 'Lab\ConsignmentCheckitemController');
    $router->resource('/customer', 'Lab\CustomerController');// 客户管理


});
