<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller{

	/**
	 * 获取用户信息
	 * @param  Request $request
	 * @return view:'user_msg';data:[...]
	 *
	 */
	public function getUser(Request $request) {
		$users = new User;
		$user = $users->find($request -> input('id'));
		return view('user_msg', ['id' => $user['id'], 'idStr' => $user['idStr'],'screen_name' => $user['screen_name'], 'province' => $user['province'], 'city' => $user['city'], 'location' => $user['location'],'description' => $user['description'],'profile_Image_url' => $user['profile_Image_url'],
        'profile_url' => $user['profile_url'],'gender' => $user['gender'],'remark' => $user['remark'], 'create_at' => $user['create_at'], 'avatar_hd' => $user['avatar_hd'], 'online_status' => $user['online_status'], 'lang' => $user['lang']]);
	}
}
