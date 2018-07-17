<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLabel extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'activity_label';

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
        'activity_id',     #活动id
        'label_id'       #label_id
    ];
}
