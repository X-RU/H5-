<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use GuzzleHttp\Client;

class UserController extends Controller{

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
		$redirect_uri = 'user/access_token';
		$display = 'mobile';
		return redirect("https://api.weibo.com/oauth2/authorize?client_id=$client_id&redirect_uri=$redirect_uri&display=$display");
	}

	/**
	 * 使用微博登录:获取access_token
	 *
	 * @return redirect to https://api.weibo.com/oauth2/access_token
	 */
	public function accessToken(Request $request) {

		$code = $request['code'];
		$client_id = '1528221042';
		$client_secret = '7dc8b9448e42a8a1be7c3021f7fb1ba6';
		$grant_type = 'authorization_code';
		$redirect_uri = 'user/get_weibo_user';
		return redirect("https://api.weibo.com/oauth2/access_token?client_id=$client_id&client_secret=$client_secret&grant_type=$grant_type&code=$code&redirect_uri=$redirect_uri");
	}

	/**
	 * 使用微博登录：获取微博上的用户信息
	 * @param  Request $request
	 * @return view:'home';data:[...]
	 */
	public function getWeiboUser(Request $request) {

		//从request中获取数据
		$access_token = $request['access_token'];

		$expires_in = $request['expires_in'];

		$uid = $request['uid'];

		$http = new Client();

		$response = $http->get("https://api.weibo.com/2/users/show.json?access_token=$access_token&uid=$uid");

		$user = new User;

		$data = json_decode((string)$response->getBody(), true);

		//将微博数据保存到用户表中
		$user->id = $data['id'];
		$user->idStr = $data['idStr'];
		$user->screen_name = $data['screen_name'];
		$user->province = $data['province'];
		$user->city = $data['city'];
		$user->location = $data['location'];
		$user->description = $data['description'];
		$user->profile_Image_url = $data['profile_Image_url'];
		$user->profile_url = $data['profile_url'];
		$user->gender = $data['gender'];
		$user->remark = $data['remark'];
		$user->avatar_hd = $data['avatar_hd'];
		$user->online_status = $data['online_status'];
		$user->lang = $data['lang'];
		$user->remember_token = api_token($user);
		$user->save();

		//利用用户进行权限验证
		Auth::login($user,true);

		return view('home', ['user'=>$user]);
	}

}
