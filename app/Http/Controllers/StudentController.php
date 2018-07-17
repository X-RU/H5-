<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Student;

class StudentController extends Controller{

	public function test3(){

		// all()方法查询所有数据
		$studnets=Student::all();
		// dd($studnets);

		//find()查询一条，依据主键查询。findOrFail()查找不存在的记录时会抛出异常
		$student=Student::find(5);  //主键为5的记录
		var_dump($student);

		//查询构造器的使用,省略了指定表名
		$student=Student::get();  
		var_dump($student);

	}

}