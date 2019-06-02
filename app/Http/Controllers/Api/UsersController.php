<?php

namespace App\Http\Controllers\Api;

use App\Transformers\UserAddressTransformer;
use App\Transformers\UserTransformer;
use App\User;
use Dingo\Api\Routing\Helpers;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    use Helpers;
    public function index()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }


    public function store(Request $request)
    {
        $code = $request->code;
        $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($code);

        // 如果结果错误，说明 code 已过期或不正确，返回 401 错误
        if (isset($data['errcode'])) {
            return $this->response->errorUnauthorized('code 不正确');
        }
        return $data;
        return 'store';
    }


    public function phoneStore(Request $request)
    {

        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;

        $credentials['password'] = $request->password;

        if (!$token = \Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);

    }

}
