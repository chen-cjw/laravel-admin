<?php

namespace App\Http\Controllers;

use EasyWeChatComposer\EasyWeChat;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $code = '033cBFU42QFoxP0WTBV42LMXU42cBFUJ';
        $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($code);
        // 如果结果错误，说明 code 已过期或不正确，返回 401 错误
        if (isset($data['errcode'])) {
            return '不正确';
            return $this->response->errorUnauthorized('code 不正确');
        }
        return $data;

    }
}
