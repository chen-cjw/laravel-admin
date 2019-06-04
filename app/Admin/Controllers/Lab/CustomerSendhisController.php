<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Models\CustomerSendhis;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CustomerSendhisController extends Controller
{
    use HasResourceActions;

    public function __construct()
    {
        $this->header = '查询待发送消息';
    }
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {

        $customerSendhis = CustomerSendhis::where('is_send',0)->paginate();
        return $customerSendhis;
    }

}
