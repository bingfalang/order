<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');
Route::get('/getMenu', 'IndexController@getMenu');
Route::get('/getUserNum', 'IndexController@getUserNum');
Route::get('/notice/{id}', 'IndexController@notice');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//用户功能
Route::group(['namespace' => 'User', 'prefix' => 'user', 'middleware' => 'auth'], function (){
    Route::get('/', 'HomeController@index');
    Route::post('/home/s', 'HomeController@search');
    //搜索功能
    Route::get('/breakfast/s', 'BreakfastController@s');
    Route::get('/lunch/s', 'LunchController@s');
    Route::get('/dinner/s', 'DinnerController@s');
    //早餐
    Route::resource('/breakfast', 'BreakfastController');
    Route::resource('/lunch', 'LunchController');
    Route::resource('/dinner', 'DinnerController');
    Route::get('/profile', 'ProfileController@index');
});

//食堂工作人员功能
Route::group(['namespace' => 'Staff', 'prefix' => 'staff', 'middleware' => ['permission:系统管理员|餐厅管理员']], function (){
    Route::get('/', 'HomeController@index');
    Route::get('/data', 'HomeController@getData');
    //报表
    Route::get('/report', 'HomeController@report');
    Route::get('/report/data', 'HomeController@getReportData');
    //菜单
    Route::post('/menu/today/{id}', 'MenuController@todayMenu');
    Route::post('/menu/mass_today', 'MenuController@massTodayMenu');
    //搜索功能，search顺序要放在@show之前
    Route::get('/menu/s', 'MenuController@s')->name('menu.search');
    Route::resource('/menu', 'MenuController');
    //定餐时限
    Route::resource('/limit', 'LimitController');
    //用户搜索功能，search顺序要放在UserController@show之前
    Route::get('/order/search', 'OrderController@search');
    //员工开停餐
    Route::resource('/order', 'OrderController');
    Route::get('/breakfast', 'BreakfastController@index');
    Route::get('/breakfast/create', 'BreakfastController@create');
    Route::get('/profile', 'ProfileController@index');
});

//管理员功能
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['permission:系统管理员']], function (){
    Route::get('/', 'HomeController@index');
    Route::resource('/dept', 'DeptController');
    //个人餐费标准历史
    Route::get('/user/price/{id}/edit', 'PriceUserController@edit');
    Route::put('/user/price/{id}', 'PriceUserController@update');
    //用户搜索功能，search顺序要放在UserController@show之前
    Route::get('/user/search', 'UserController@search');
    Route::resource('/user', 'UserController');
    Route::resource('/fee', 'FeeController');
    //权限管理
    Route::resource('/role', 'RoleController');
    Route::resource('/permit', 'PermissionController');
    //报表
    Route::get('/report', 'ReportController@index');
    Route::post('/report/setData', 'ReportController@setData');

});

Route::group(['namespace' => 'Common', 'prefix' => 'common', 'middleware' => ['permission:系统管理员|餐厅管理员']], function (){
    Route::resource('/calendar', 'CalendarController');
    Route::resource('/notice', 'NoticeController');

});