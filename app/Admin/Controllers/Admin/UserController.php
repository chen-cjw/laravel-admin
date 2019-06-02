<?php

namespace App\Admin\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
{
    use HasResourceActions;
    public function __construct()
    {
        $this->header = '会员';
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('编号')->sortable();
        $grid->name('用户名');
        $grid->phone('号码')->sortable();
        $grid->weapp_openid('Openid');
        $grid->weixin_session_key('weixin_session_key');
        //$grid->password('Password');
        $grid->point('积分')->sortable();
        $grid->deleted_at('禁用时间')->sortable();
        $grid->created_at('创建时间')->sortable();
        $grid->updated_at('编辑时间')->sortable();
        // 查询过滤
        $grid->filter(function($filter){
            // 在这里添加字段过滤器
            $filter->like('name', '用户名');
            $filter->like('phone', '号码');

        });

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
        $show = new Show(User::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->phone('Phone');
        $show->weapp_openid('Weapp openid');
        $show->weixin_session_key('Weixin session key');
        $show->password('Password');
        $show->point('Point');
        $show->deleted_at('Deleted at');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', 'Name');
        $form->mobile('phone', 'Phone');
        $form->text('weapp_openid', 'Weapp openid');
        $form->text('weixin_session_key', 'Weixin session key');
        $form->password('password', 'Password');
        $form->decimal('point', 'Point')->default(0.00);

        return $form;
    }
}
