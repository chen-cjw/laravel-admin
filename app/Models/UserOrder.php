<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    //$table->unsignedInteger('user_id')->comment('该订单所属的用户');
    //$table->unsignedInteger('user_address_id')->comment('该用户的地址');
    //$table->string('address')->comment('地址');
    //$table->text('leave_message')->comment('留言'); // csrf 没做
    //$table->text('critical_contact_phone')->comment('紧急联系电话');
    //$table->string('image')->comment('发送货物拍照');
    //$table->string('order_code')->comment('订单号');
    //$table->string('send_name')->comment('发货人');
    //$table->string('send_content_phone')->comment('发货人联系方式');

    protected $fillable = [
        'user_id','user_address_id','address','leave_message',
        'critical_contact_phone','image','order_code','send_name','send_content_phone'
    ];

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class);
    }
}
