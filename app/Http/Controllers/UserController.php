<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Activity;
use App\Token;
use App\UserActivity;
use GuzzleHttp\Client;
use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller
{

	/**
	 * //验证前端传来的token是否有效
	 * @param  Request $request
	 * @return code
	 */
	public function checkToken(Request $request) {
		$token_value = $request['token'];
		//若获取的token为空，则返回400
		if($token_value == null)
			return ['code'=>400];
		//取出数据库中相应的记录
		$token = App\Token::where('token_value', $token_value);
		//若数据库中没有该token，则返回400
		if($token == null)
			return ['code'=>400];
		//设置时间区域，PRC代表中国
		date_default_timezone_set(PRC);
		//若当前时间已经超过时效时间，则返回400
		if(strtotime(date("Y-m-d H:i:s"))>strtotime($token->expires_in))
			return ['code'=>400];
		//当前token通过重重关卡，返回200
		return ['code'=>200];
	}

	/**
	 * 获取用户信息
	 * @param  Request $request
	 * @return view:'user_msg';data:[...]
	 *
	 */
	public function getUser($id) {

		$users = new User;

		$user = $users->find($id);

		return response()->json(['code' =>'200', 'message' => 'success', 'data' =>$user]);
	}

	/**
	 * 使用微博登录：获取code
	 *
	 * @return redirect to https://api.weibo.com/oauth2/authorize
	 */
	public function weiboLogin() {

		$client_id = '1528221042';
		$redirect_uri = urlencode('http://h5.jayna.fun/user/get_weibo_user');
		$display = 'mobile';
		return redirect("https://api.weibo.com/oauth2/authorize?client_id=$client_id&redirect_uri=$redirect_uri&display=$display");
	}

	/**
	 * 使用微博登录:获取access_token
	 *
	 * @return redirect to https://api.weibo.com/oauth2/access_token
	 */
	public function getWeiboUser(Request $request) {
		$code = $request['code'];
		$params = [
			'client_id' => '1528221042',
			'client_secret' => '7dc8b9448e42a8a1be7c3021f7fb1ba6',
			'grant_type' => 'authorization_code',
			'redirect_uri' => 'http://h5.jayna.fun/user/access_token',
			'code' => $code
		];
		$http = new Client();
		$requestBody = $http->request('POST', "https://api.weibo.com/oauth2/access_token",['form_params' => $params])->getBody();

		$contents = json_decode($requestBody->getContents(), true);

		$access_token = $contents['access_token'];
		$uid = $contents['uid'];

		$response = $http->get("https://api.weibo.com/2/users/show.json?access_token=$access_token&uid=$uid");

		$data = json_decode((string)$response->getBody(), true);

		$user = new User;

		$id = $data['id'];
		$user_db = User::find($id);
		//建立一个最后登录的$user_login,减少代码。
		$user_login = null;
		if(null == $user_db){
			$user->id = $id;
			$user->idStr = $data['idstr'];
			$user->screen_name = $data['screen_name'];
			$user->province = $data['province'];
			$user->city = $data['city'];
			$user->location = $data['location'];
			$user->description = $data['description'];
			$user->profile_Image_url = $data['profile_image_url'];
			$user->profile_url = $data['profile_url'];
			$user->gender = $data['gender'];
			$user->remark = $data['remark'];
			$user->avatar_hd = $data['avatar_hd'];
			$user->online_status = $data['online_status'];
			$user->lang = $data['lang'];
			// 将微博数据保存到用户表中
			$user->save();

			//表示登录成功的用户是$user
			$user_login = $user;
		}
		else{
			//表示登录成功的用户是$user_db
			$user_login = $user_db;
		}

		// 利用用户进行权限验证
		Auth::login($user_login,true);

		//生成token
		$token = new Token();
		//token_value
		$token_value = str_random(60);
		$token->token_value = $token_value;
		$token->user_id = $id;
		//获取当前时间，并加上30分钟（作为有效时间）存到库里。
		date_default_timezone_set(PRC);
		$date_now = date("Y-m-d H:i:s");
		$token->expires_in = date("Y-m-d H:i:s", strtotime($date_now) + 30*60);
		$token->save();

		return redirect("http://10.11.26.2:8080/?token=$token");
	}


	public function activityList($user_id){

		$theActivitiesICreate = array();

		//查询用户创建的活动
		$theActivitiesICreate = Activity::where('init_user_id',$user_id)->get();

		//dd($theActivitiesICreate);

		//查询用户参加的活动关系
		$activity_relations = UserActivity::where('user_id',$user_id)->get();

		//创建活动id列表
		$activity_id_list = array();

		//根据用户活动关系获取活动id
		foreach($activity_relations as $activity_relation){

			array_push($activity_id_list,$activity_relation->activity_id);

		}

		$theActivitiesIAttend = array();

		//我参加的活动
		$theActivitiesIAttend = Activity::find($activity_id_list);

		$total = $theActivitiesIAttend->merge($theActivitiesICreate);


		$userController = new UserController;

		return $userController->response_cjj($total,'200','success');
	}

	//装饰response接口
	public function response_cjj($data, $code = '200', $message = 'success'){

		return response()->json(['code' =>$code, 'message' => $message, 'data' =>$data]);

	}
}
