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
    return json_encode([
        '验证密码'=>'/getInfo',
        '获得所有成绩'=>'/getScore',
        '获取课表'=>'/getTimetable',
        '获取创新学分'=>'/getInnovativeCredit',
        '已获得选修课学分与成绩'=>'/getElectiveScore',
        '课程历史修改记录'=>'/getLogs',
        '可选公选课列表'=>'/getElectiveList',
        '学期已选课程'=>'/getSelectedCourses'
        ]);
});
//验证密码
$router->get('/getInfo','API\QueryController@getInfo');
//获得所有成绩
$router->get('/getScore','API\QueryController@getScore');
//获取课表
$router->get('/getTimetable','API\QueryController@getTimetable');
//获取创新学分
$router->get('/getInnovativeCredit','API\QueryController@getInnovativeCredit');
//已获得选修课学分与成绩
$router->get('/getElectiveScore','API\QueryController@getElectiveScore');
//课程历史修改记录
$router->get('/getLogs','API\QueryController@getLogs');
//教学计划：这个html解析太麻烦，放弃
//$router->get('/getPlan','API\QueryController@getPlan');
//可选公选课列表
$router->get('/getElectiveList','API\QueryController@getElectiveList');
//学期已选课程
$router->get('/getSelectedCourses','API\QueryController@getSelectedCourses');
//输出php环境
$router->get('/phpinfo',function(){
    echo phpinfo();
});
