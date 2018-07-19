<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'activity';

    /**
     * 主键
     *
     * @var int
     */
    protected $primaryKey = 'id';

    //活动创建时间，系统自动维护，默认还有活动更新时间
    // const CREATED_AT = 'create_time'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $fillable = [
        'title',     #活动名称
        'time',  #活动时间
        'location',        #活动位置
        'latitude_longitude',    #活动的经纬度，现在改变成活动的活动的省市县了
        'init_user_id',    #活动创建人的id
        'picture_url',     #活动图片的url
        'description',     #活动的介绍
        'status'
    ];
}
