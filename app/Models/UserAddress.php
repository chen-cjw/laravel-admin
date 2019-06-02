<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //$table->unsignedInteger('user_id')->comment('该地址所属的用户');
    //$table->string('province')->comment('省');
    //$table->string('city')->comment('市');
    //$table->string('district')->comment('区');
    //$table->string('address')->comment('具体地址');
    //$table->string('contact_name')->comment('联系人姓名');
    //$table->string('contact_phone')->comment('联系人电话');
    //$table->string('last_used_at')->comment('最后一次使用时间');
    protected $fillable = ['user_id','province','city','district','address','contact_name','contact_phone','last_used_at'];
}
