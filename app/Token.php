<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'token';

    /**
     * 主键
     *
     * @var int
     */
    protected $primaryKey = 'id';


    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $fillable = [
        'token_value',      #Token值
        'user_id',          #user_id
        'expires_in'        #过期时间
    ];
}
