<?php

namespace App\Transformers;

use App\Models\Products;
use App\User;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    //        'name', 'phone', 'weapp_openid','weixin_session_key','password','point','user_level_id','deleted_at'
    public function transform(User $user)
    {
        return [
            'id'=>$user->id,
            'name'=>$user->name,
            'phone'=>$user->phone,
            'weapp_openid'=>$user->weapp_openid,
            'weixin_session_key'=>$user->weixin_session_key,
            //'password'=>$user->password,
            'point'=>$user->point,
            'user_level_id'=>$user->user_level_id,
            'user_level_id'=>$user->userLevel(),
            'deleted_at'=>$user->deleted_at,
        ];
    }
}
