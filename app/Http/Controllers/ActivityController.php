<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Activity;
use App\UserActivity;
use App\User;

class ActivityController extends Controller{


	/**
	 * 只允许登录用户访问
	 */
	// public function __construct()
	// {
	//     Auth::guard()->check();
	// }

	 /**
     * 用户创建活动
     *
     * @param Request $request
     * @return Response
     */
	public function projectCreate(Request $request){

		$activity = new Activity;

		//活动的主题
		$title = $request->input('title');

		if(is_null($title))
			$title = "";

		$activity->title = $title;

		//活动时间（设置成为，某时，某刻某分）
		$time = $request->input('time');

		if(is_null($time))
			$time = "";

		$activity->time = $time;

		//活动的具体位置
		$location = $request->input('location');

		if(is_null($location))
			$location = "";

		$activity->location = $location;

		//活动的经纬度（现在该字段用来表明活动的省市县）
		$latitude_longitude = $request->input('latitude_longitude');

		if(is_null($latitude_longitude))
			$latitude_longitude = "";

		$activity->latitude_longitude = $latitude_longitude;

		//token是指
		$token = $request->input('token');
		$user = User::where('remember_token',$token)->first();
		$activity->init_user_id = $user->id;


		//获取照片的url
		$picture_url = $request->input('picture');

		if(is_null($picture_url))
			$picture_url = "";//如果picture_url为空的话，就使用默认图片
		$activity->picture_url = $picture_url;

		//获取活动描述
		$description = $request->input('description');

		if(is_null($description))
			$description = "该用户很懒，什么都没填。";
		$activity->description = $description;

		var_dump($activity->save());

		$activityController = new ActivityController();

		//返回调用response
		return $activityController ->response_cjj($activity,'200','success');

	}

    /**
     * 用户更新活动
     *
     * @param Request $request
     * @return Response
     */
	public function projectUpdate(Request $request){

		//获取id
		$id = $request->input('id');

		//根据id获取activity
		$activity = Activity::find($id);

		//活动的主题
		$title = $request->input('title');

		if(!is_null($title)&&$title!="")
			$activity->title = $title;

		//活动时间（设置成为，某时，某刻某分）
		$time = $request->input('time');

		if(!is_null($time)&&$time!="")
			$activity->time = $time;

		//活动的具体位置
		$location = $request->input('location');

		if(!is_null($location)&&$location!="")
			$activity->location = $location;

		//活动的经纬度（现在该字段用来表明活动的省市县）
		$latitude_longitude = $request->input('latitude_longitude');

		if(!is_null($latitude_longitude)&&$latitude_longitude!="")
			$activity->latitude_longitude = $latitude_longitude;

		//获取照片的url
		$picture_url = $request->input('picture');

		if(!is_null($picture_url)&&$picture_url!="")
			$activity->picture_url = $picture_url;

		//获取活动描述
		$description = $request->input('description');

		if(!is_null($description)&&$description!="")
			$activity->description = $description;

		var_dump($activity->save());

		$activityController = new ActivityController();

		//返回调用response
		return $activityController ->response_cjj($activity,'200','success');
		
	}

    /**
     * 用户参加活动
     *
     * @param Request $request
     * @return Response
     */
	public function projectAttend(Request $request){

		$activity_id = $request->input('activity_id');

		$user_id = $request->input('user_id');

		if(is_null($user_id))
			$user_id = 234;

		$userActivity = new UserActivity;

		$userActivity->user_id = $user_id;

		$userActivity->activity_id = $activity_id;

		$userActivity->save();

		$activityController = new ActivityController();

		//返回调用response
		return $activityController ->response_cjj('','200','success');
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