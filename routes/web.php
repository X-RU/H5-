<?php

use Illuminate\Http\Request;

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
	Route::get('theProjectICreate','ActivityController@theProjectICreate')->name('theProjectICreate');

	//我参加的活动路由
	Route::get('theProjectIAttend','ActivityController@theProjectIAttend')->name('theProjectIAttend');

	//搜索活动路由
	Route::get('search','ActivityController@projectSearch')->name('projectSearch');

	//活动管理
	Route::get('manager/{project_id}','ActivityController@manager')->name('manager');

	//某一活动的详细内容路由
	Route::get('detailed/{project_id}','ActivityController@detailedProjectInformation')->name('detailedProjectInformation');

	//某一活动的参与人员路由
	Route::get('relationPeople/{project_id}','ActivityController@relationPeople')->name('relationPeople');

	Route::get('allActivity', 'ActivityController@activityList');

});

Route::group(['prefix' => '/user'], function() {
	//验证用户是否登录
	Route::get('/check_login', 'UserController@checkLogin');

	//获取用户信息
	Route::get('/message', 'UserController@getUser')->middleware('auth');

	//使用微博登录：获取code
	Route::get('/weibo_login', 'UserController@weiboLogin');

	//使用微博登录：获取access_token
	Route::get('/access_token', 'UserController@accessToken');

	//使用微博登录：获取用户信息
	Route::get('/get_weibo_user', 'UserController@getWeiboUser');

	//更新用户头像
	Route::post('/update', 'UserController@updateUser')->middleware('auth');

	//与用户有关的所有的活动的列表路由
	Route::get('/activityList','UserController@activityList')->name('activityList');
});
