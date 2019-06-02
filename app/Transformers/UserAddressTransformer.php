<?php

namespace App\Transformers;

use App\Models\Products;
use App\Models\UserAddress;
use App\User;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class UserAddressTransformer extends TransformerAbstract
{
    //protected $fillable = ['user_id','province','city','district','address','contact_name','contact_phone','last_used_at'];
    public function transform(UserAddress $address)
    {
        return [
            'id'=>$address->id,
            'user_id'=>$address->user_id,
            'province'=>$address->province,
            'city'=>$address->city,
            'district'=>$address->district,
            //'password'=>$user->password,
            'address'=>$address->address,
            'contact_name'=>$address->contact_name,
            'contact_phone'=>$address->contact_phone,
            'last_used_at'=>$address->last_used_at,
        ];
    }
}
