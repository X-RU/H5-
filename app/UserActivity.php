<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'user_activity';

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
        'user_id',     #用户ID
        'activity_id'       #标签id
    ];
}
