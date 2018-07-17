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
|    type 1:
|  
|    Route::get('users', function () {
|       // Matches The "/admin/users" URL
|    });
|
|    type 2:
|     
|    Route::post('/project/create','ActivityController@create')->name('projectCreate');
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'hello,world';
});



Auth::routes();

//使用 name 方法链的方式来定义该路由的名称
Route::get('/home', 'HomeController@index')->name('home');

//为路由添加前缀
Route::group(['prefix'=> 'project'], function () {

	//活动发起人创建活动路由
	Route::post('create','ActivityController@projectCreate')->name('projectCreate');

	//活动发起人更新活动路由
	Route::post('update','ActivityController@projectUpdate')->name('projectUpdate');

	//用户参加活动路由
	Route::post('attend','ActivityController@projectAttend')->name('projectAttend');

	//我创建的活动路由
	Route::get('theProjectICreate/{user_id}','ActivityController@theProjectICreate')->name('theProjectICreate');

	//我参加的活动路由
	Route::get('theProjectIAttend/{user_id}','ActivityController@theProjectIAttend')->name('theProjectIAttend');

	//搜索活动路由
	Route::get('search','ActivityController@projectSearch')->name('projectSearch');

});

//为路由添加前缀
Route::group(['prefix'=> 'project'], function () {

	//更新我的个人信息
	Route::post('update','UserController@updateMyMessage')->name('updateMyMessage');
	
	//给某一用户推荐活动
	Route::get('recommend','UserController@recommendActivityToUser')->name('recommendActivityToUser');

	//获取我的个人信息
	Route::get('message','UserController@getMyMessage')->name('getMyMessage');
	
});





