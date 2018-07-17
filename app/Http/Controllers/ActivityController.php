<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Activity;
use App\UserActivity;

class ActivityController extends Controller{


	/**
	 * 只允许登录用户访问
	 */
	// public function __construct()
	// {
	//     $this->middleware('auth');
	// }

	 /**
     * 用户创建活动
     *
     * @param Request $request
     * @return Response
     */
	public function projectCreate(Request $request){

		//活动的主题
		$title = $request->input('title');

		if(is_null($title))
			$title = "";

		//活动时间（设置成为，某时，某刻某分）
		$time = $request->input('time');

		if(is_null($time))
			$time = "";

		//活动的具体位置
		$location = $request->input('location');

		if(is_null($location))
			$location = "";

		//活动的经纬度（现在该字段用来表明活动的省市县）
		$latitude_longitude = $request->input('latitude_longitude');

		if(is_null($latitude_longitude))
			$latitude_longitude = "";

		$token = $request->input('token');//token不可能为null,token为空的话就没办法进入这个controller

		$picture_url = $request->input('picture_url');

		if(is_null($picture_url))
			$picture_url = "";//如果picture_url为空的话，就使用默认图片

	}

    /**
     * 用户更新活动
     *
     * @param Request $request
     * @return Response
     */
	public function projectUpdate(Request $request){
		
	}

    /**
     * 用户参加活动
     *
     * @param Request $request
     * @return Response
     */
	public function projectAttend(Request $request){


		
	}

    /**
     * 用户自己创建的活动列表
     *
     * @param int $user_id
     * @return Response
     */
	public function theProjectICreate($user_id){

		//查询用户创建的活动
		$activity_list = Activity::where('init_user_id',$user_id)->get();

		//实例化类
		$activityController = new ActivityController();

		//返回调用response
		return $activityController ->response_cjj($activity_list,'200','success');

	}

    /**
     * 用户自己参加的活动列表
     *
     * @param int $user_id
     * @return Response
     */
	public function theProjectIAttend($user_id){

		//查询用户参加的活动关系
		$activity_relations = UserActivity::where('user_id',$user_id)->get();

		//创建活动id列表
		$activity_id_list = array(); 

		//根据用户活动关系获取活动id
		foreach($activity_relations as $activity_relation){

			array_push($activity_id_list,$activity_relation->activity_id);

		}

		//根据活动id查询活动
		$activity_list = Activity::find($activity_id_list);

		//实例化类
		$activityController = new ActivityController();

		//返回调用response
		return $activityController ->response_cjj($activity_list,'200','success');
	}

    /**
     * 搜索活动
     *
     * @param Request $request
     * @return Response
     */
	public function projectSearch(Request $request){
		
	}

	//装饰response接口
	public function response_cjj($data, $code = '200', $message = 'success'){

		return response()->json(['code' =>$code, 'message' => $message, 'data' =>$data]);

	}

}