<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller{
	
	/**
	 * 只允许登录用户访问
	 */
	public function __construct()
	{
	    $this->middleware('auth');
	}

	 /**
	}
}
