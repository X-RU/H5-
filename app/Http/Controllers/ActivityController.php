<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Activity;
use App\UserActivity;
use App\User;

class ActivityController extends Controller{


	/**
	 * 只允许登录用户访问
	 */
	public function __construct()
	{
	    $this->middleware('auth');
	}

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

		$user = Auth::user();
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

		$status = "尚未开始";

		$activity->status = $status;

		$activity->save();	
		$id = $activity->id;
		$data['id'] = $id;

		$activityController = new ActivityController();

		//返回调用response
		return $activityController ->response_cjj($data,'200','success');

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

		$status = $request->input('status');
		if(!is_null($status))
			$activity->status = $status;

		//获取照片的url
		$picture_url = $request->input('picture');

		if(!is_null($picture_url)&&$picture_url!="")
			$activity->picture_url = $picture_url;

		//获取活动描述
		$description = $request->input('description');

		if(!is_null($description)&&$description!="")
			$activity->description = $description;

		$activity->save();

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

		//获取用户id
		$user = Auth::user();
		$user_id = $user->id;

		$userActivity = new UserActivity;

		$userActivity->user_id = $user_id;

		$userActivity->activity_id = $activity_id;

		$activityController = new ActivityController();

		if($userActivity->save())
			//返回调用response
			return $activityController ->response_cjj('','200','报名成功');
		else
			return $activityController ->response_cjj('','201','报名失败');
	}


    /**
     * 用户取消活动
     *
     * @param Request $request
     * @return Response
     */
	public function projectCancel(Request $request){
	
		$activity_id = $request->input('activity_id');
		$activity    = Activity::where('id',$activity_id)->get();

		//获取用户id
		$user = Auth::user();
		$user_id = $user->id;

		$activityController = new ActivityController();

			$userActivity = UserActivity::where('activity_id',$activity_id)->where('user_id',$user_id);


		if($userActivity->delete())
			//返回调用response
			return $activityController ->response_cjj('','200','取消报名成功');
		else
			return $activityController ->response_cjj('','201','取消报名失败');
	}


    /**
     * 用户自己创建的活动列表
     *
     * @param int $user_id
     * @return Response
     */
	public function theProjectICreate(){

		$user = Auth::user();
		$user_id = $user->id;

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
	public function theProjectIAttend(){


		$user = Auth::user();
		$user_id = $user->id;

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

    /**
     * 某一活动的详细信息
     *
     * @param int $project_id
     * @return Response
     */
	public function detailedProjectInformation($project_id){

		//实例化类
		$activityController = new ActivityController();

		$project = Activity::where('id',$project_id)->get()->first();

		if(!is_null($project)){

			$data = array();
			$init_user_id = $project->init_user_id;
			$init_user = User::where('id',$init_user_id)->get()->first();
			$init_user_name = $init_user->screen_name;

			//往$data中填充数据
			$data['creator'] = $init_user_name;
			$data['title'] = $project->title;
			$data['time'] = $project->time;
			$data['latitude_longitude'] = $project->latitude_longitude;
			$data['location'] = $project->location;
			$data['description'] = $project->description;


			//获取当前登陆的用户的信息
			$user = Auth::user();

			//如果当前登陆用户和活动发起人相同，那么就说明这个人是活动发起人，否则这个人就不是活动发起人
			if($user->id == $init_user_id){
				$data['isManager'] = 'true';
			}
			else{
				$data['isManager'] = 'false';
			}
			
			$status = UserActivity::where('user_id', $init_user_id)->where('activity_id', $project_id)->get();
			if($status->isEmpty()){
				$data['status'] = 'false';
			} else {
				$data['status'] = 'true';
			}

			return $activityController->response_cjj($data,'200','success');
		}
		else{
			return $activityController->response_cjj($project,'400','failure');
		}

	}


	 /**
     * 与活动有关的人员信息
     *
     * @param int $project_id
     * @return Response
     */
	public function relationPeople($project_id){

		$userActivityList = UserActivity::where('activity_id',$project_id)->get();

		//创建用户id列表数组
		$user_id_list = array(); 

		//根据用户活动关系获取活动id
		foreach($userActivityList as $userActivity){

			array_push($user_id_list,$userActivity->user_id);

		}

		//根据活动id列表查询用户
		$user_list = User::find($user_id_list);

		//提取每个用户的screen_name、description、gender字段来显示。
		$users = array();
		foreach ($user_list as $user) {
			# code...
			$user_message = array();
			$user_message['screen_name'] = $user->screen_name;
			$user_message['description'] = $user->description;
			$user_message['gender'] = $user->gender;
			$user_message['picture_url'] = $user->profile_url;
			array_push($users,$user_message);
		}

		//实例化类
		$activityController = new ActivityController();

		//返回调用response
		return $activityController ->response_cjj($users,'200','success');

	}

	//管理活动
	public function manager($project_id){

		$activity = Activity::where('id',$project_id)->get();

		//实例化类
		$activityController = new ActivityController();

		//返回调用response
		return $activityController ->response_cjj($activity,'200','success');
	}

	public function activityList(Request $request) {
		$activityList = Activity::all();

		$activityController = new ActivityController();

		return $activityController -> response_cjj($activityList, '200', 'success');
	}

	//装饰response接口
	public function response_cjj($data, $code = '200', $message = 'success'){

		return response()->json(['code' =>$code, 'message' => $message, 'data' =>$data]);

	}

}
