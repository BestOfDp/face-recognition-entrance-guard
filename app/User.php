<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * 不可被批量赋值的属性。
     */
    protected $guarded = [];

    /**
     * 返回数据的时候隐藏值
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /**
     * 获得此用户的角色。
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role','user_roles');
    }

    /**
     * 获得此用户的绑定的地址。
     */
    public function addresses()
    {
        return $this->belongsToMany('App\Address','user_addresses')->withPivot('created_at', 'role_id', 'nickname', 'time', 'grantor')->withTimestamps();
    }

    /**
     * 获得此用户的识别码。
     */
    public function code()
    {
        return $this->hasOne('App\UserCode');
    }

    /**
     * 获得此用户的访问记录。
     */
    public function visits()
    {
        return $this->hasMany('App\Visit');
    }
}
