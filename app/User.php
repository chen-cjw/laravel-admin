<?php

namespace App;

use App\Models\UserAddress;
use App\Models\UserLevel;
use App\Models\UserOrder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //$table->string('name');
    //$table->string('phone')->nullable()->unique();
    //$table->string('weapp_openid')->nullable()->unique();
    //$table->string('weixin_session_key')->nullable();
    //$table->string('password')->nullable();
    //$table->decimal('point',[10,0])->default(0);
    //$table->unsignedInteger('user_level_id')->comment('用户等级')->default(0);
    //$table->timestamp('deleted_at')->nullable();

    protected $fillable = [
        'name', 'phone', 'weapp_openid','weixin_session_key','password','point','user_level_id','deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // 地址
    public function userAddress()
    {
        return $this->hasMany(UserAddress::class,'user_id');
    }
    // 用户等级
    public function userLevel()
    {
        return $this->hasOne(UserLevel::class);
    }
    // 用户订单
    public function userOrder()
    {
        return $this->hasMany(UserOrder::class);
    }
    
    
    
}
