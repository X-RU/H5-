<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
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
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
<<<<<<< HEAD
        'id','idStr','screen_name', 'province', 'city','location','description','profile_Image_url',
        'profile_url','remark'，'avatar_hd','online_status','lang','create_at','update_at'
=======
        'id','idStr','screen_name', 'province', 'city',
        'location','description','profile_Image_url',
        'profile_url','remark','avatar_hd','online_status','lang'
>>>>>>> dev
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
