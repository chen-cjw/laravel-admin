<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::post('/api/sample/add_sampleorder', 'App\Admin\Controllers\Api\ConsignmentSampleController@addSampleOrder');//

//Route::get('/api/sample/add_sampleorder', 'App\Admin\Controllers\Api\ConsignmentSampleController@addSampleOrder');//

// 新增任务记录接口

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->post('/consignment_report/download', 'Lab\ConsignmentReportController@download');

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/users', 'Admin\UserController');
    $router->post('/consignment_sample/update_report_is_send', 'Lab\ConsignmentSampleController@updateReportIsSend');
    $router->resource('/consignment_sample', 'Lab\ConsignmentSampleController');

    $router->resource('/consignment_report', 'Lab\ConsignmentReportController');
    $router->resource('/consignment_checkitem', 'Lab\ConsignmentCheckitemController');
    $router->resource('/customer', 'Lab\CustomerController');// 客户管理
    $router->resource('/consignment_checkitem_data', 'Lab\ConsignmentCheckitemDataController');// 项目数据
    $router->resource('/org', 'Lab\OrgController');// 部门管理
    $router->post('/consignment_sample/update_report_is_send_all', 'Lab\ConsignmentSampleController@updateReportIsSendAll');//测试


});
