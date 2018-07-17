<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{
	
	/**
	 * 只允许登录用户访问
	 */
	public function __construct()
	{
	    $this->middleware('auth');
	}

	 /**
     * 更新用户个人信息（这个在本次开发过程中并不需要）
     *
     * @param Request $request
     * @return Response
     */
	public function updateMyMessage(Request $request){

	}

	 /**
     * 给用户推荐活动
     *
     * @param int $user_id
     * @return Response
     */
	public function recommendActivityToUser(){

	}

	 /**
     * 获取我的个人信息
     *
     * @param int $user_id
     * @return Response
     */
	public function getMyMessage(){

	}
}