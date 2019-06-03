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


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CustomerSendhis);

        $grid->id('Id');
        $grid->code('Code');
        $grid->name('Name');
        $grid->openid('Openid');
        $grid->send_time('Send time');
        $grid->is_send('Is send');
        $grid->create_time('Create time');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(CustomerSendhis::findOrFail($id));

        $show->id('Id');
        $show->code('Code');
        $show->name('Name');
        $show->openid('Openid');
        $show->send_time('Send time');
        $show->is_send('Is send');
        $show->create_time('Create time');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CustomerSendhis);

        $form->text('code', 'Code');
        $form->text('name', 'Name');
        $form->text('openid', 'Openid');
        $form->number('send_time', 'Send time');
        $form->switch('is_send', 'Is send');
        $form->number('create_time', 'Create time');

        return $form;
    }
}
