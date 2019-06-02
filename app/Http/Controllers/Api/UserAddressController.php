<?php

namespace App\Http\Controllers\Api;

use App\Models\UserAddress;
use App\Transformers\UserAddressTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAddressController extends Controller
{
    use Helpers;
    public function index()
    {
        $userAddress = $this->user()->userAddress;
        return $this->response->item($userAddress, new UserAddressTransformer());
    }

    public function store(Request $request)
    {
        $data = $request->only(['province','city','district','address','contact_name','contact_phone']);
        $data['last_used_at'] = date('Y-m-d H:i:s');
        $data['user_id'] = $this->user()->id;
        //$this->user()->userAddress->create($data);
        UserAddress::create($data);
        return $this->response->created(); // 响应状态是 201
    }

    public function update(Request $request,$id)
    {
        $data = $request->only(['province','city','district','address','contact_name','contact_phone']);
        $data['last_used_at'] = date('Y-m-d H:i:s');
        $this->user()->userAddress()->where('id',$id)->update($data);
        return $this->response->created(); // 响应状态是 201
    }

    public function destroy($id)
    {
        $this->user()->userAddress->where('id',$id)->delete();
    }
}
