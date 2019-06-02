<?php

namespace App\Transformers;

use App\Models\Products;
use App\Models\UserOrder;
use App\User;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class UserOrderTransformer extends TransformerAbstract
{
    public function transform(UserOrder $userOrder)
    {
        return [
            'id'=>$userOrder->id,
            'user_id'=>$userOrder->user_id,
            'address'=>$userOrder->address,
            'leave_message'=>$userOrder->leave_message,
            'critical_contact_phone'=>$userOrder->critical_contact_phone,
            'image'=>$userOrder->image,
            'order_code'=>$userOrder->order_code,
            'send_name'=>$userOrder->send_name,
            'send_content_phone'=>$userOrder->send_content_phone,
        ];
    }
}
