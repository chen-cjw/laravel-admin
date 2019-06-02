<?php

namespace App\Http\Controllers\Api;

use App\Models\UserAddress;
use App\Transformers\UserAddressTransformer;
use App\Transformers\UserOrderTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserOrderController extends Controller
{
    use Helpers;
    public function userOrder()
    {
        $userOrder = $this->user()->userOrder;
        return $this->response->paginator($userOrder,new UserOrderTransformer());
    }
    public function store(Request $request)
    {
        // leave_message 留言
        $data = $request->only([
            'user_address_id','address','leave_message',
            'critical_contact_phone','image','order_code','send_name','send_content_phone'
        ]);
        $data['last_used_at'] = date('Y-m-d H:i:s');
        $data['user_id'] = $this->user()->id;
        //$this->user()->userOrder->create($data);
        UserAddress::create($data);
        return $this->response->created(); // 响应状态是 201
    }
    public function update(Request $request,$id)
    {
        $data = $request->only([
            'user_address_id','address','leave_message',
            'critical_contact_phone','image','order_code','send_name','send_content_phone'
        ]);
        $this->user()->userAddress()->where('id',$id)->update($data);
        return $this->response->created(); // 响应状态是 201
    }
    public function destroy($id)
    {
        $this->user()->userOrder->where('id',$id)->delete();
    }
}
