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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
//验证密码
$router->get('/getInfo','API\QueryController@getInfo');
//获取创新学分
$router->get('/getInnovativeCredit','API\QueryController@getInnovativeCredit');
//获得所有成绩
$router->get('/getScore','API\QueryController@getScore');
//获取课表
$router->get('/getTimetable','API\QueryController@getTimetable');
//教学计划
//课程历史修改记录
//已获得选修课学分与成绩
$router->get('/getElectiveScore','API\QueryController@getElectiveScore');
//可选公选课列表
$router->get('/getElectiveList','API\QueryController@getElectiveList');
