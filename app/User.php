<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * 主键
     *
     * @var int
     */
    protected $primaryKey = 'id';

    //设置主键是非递增的，是可以自己设置的。
    protected $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','idStr','screen_name', 'province', 'city','location','description','profile_Image_url',
        'profile_url','remark'，'avatar_hd','online_status','lang','create_at','update_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
}
