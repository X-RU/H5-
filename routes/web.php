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

Route::get('/user/message', 'UserController@getUser');

Auth::routes();

//使用 name 方法链的方式来定义该路由的名称
Route::get('/', 'HomeController@index')->name('home');

//为路由添加前缀
Route::group(['prefix'=> 'project'], function () {

	//活动发起人创建活动路由
	Route::post('create','ActivityController@projectCreate')->name('projectCreate');

	//活动发起人更新活动路由
	Route::post('update','ActivityController@projectUpdate')->name('projectUpdate');

	//用户参加活动路由
	Route::post('attend','ActivityController@projectAttend')->name('projectAttend');

	//用户取消活动路由
	Route::post('cancel','ActivityController@projectCancel')->name('projectCancel');

	//我创建的活动路由
	Route::get('theProjectICreate/{user_id}','ActivityController@theProjectICreate')->name('theProjectICreate');

	//我参加的活动路由
	Route::get('theProjectIAttend/{user_id}','ActivityController@theProjectIAttend')->name('theProjectIAttend');

	//搜索活动路由
	Route::get('search','ActivityController@projectSearch')->name('projectSearch');

	//活动管理
	Route::get('manager/{project_id}','ActivityController@manager')->name('manager');

	//某一活动的详细内容路由
	Route::get('detailed/{project_id}','ActivityController@detailedProjectInformation')->name('detailedProjectInformation');

	//某一活动的参与人员路由
	Route::get('relationPeople/{project_id}','ActivityController@relationPeople')->name('relationPeople');

});


//获取用户信息路由
Route::get('/user/message/{id}', 'UserController@getUser')->middleware('auth');

//使用微博登录：获取code
Route::get('/user/weibo_login', 'UserController@weiboLogin');

//使用微博登录：获取access_token
Route::get('/user/access_token', 'UserController@accessToken');

//使用微博登录：获取用户信息
Route::get('/user/get_weibo_user', 'UserController@getWeiboUser');

//与用户有关的所有的活动的列表路由
Route::get('/user/activityList/{user_id}','UserController@activityList')->name('activityList');








