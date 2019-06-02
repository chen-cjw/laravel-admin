<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    //$table->string('name')->comment('等级名称');
    //$table->unsignedInteger('level')->comment('用户等级');
    //$table->decimal('point',[10,0])->comment('达到的积分等级');
    //$table->decimal('several_fold',,[3,1])->comment('几折');
    //$table->unsignedInteger('address_max_number')->comment('用户创建地址的最大数量');
    protected $fillable = ['name','level','point','several_fold','address_max_number'];
}
