<?php

namespace App\Admin\Controllers\Admin;

use App\Models\UserOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserOrderController extends Controller
{
    use HasResourceActions;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserOrder);

        $grid->id('Id');
        $grid->user_id('User id');
        $grid->user_address_id('User address id');
        $grid->address('Address');
        $grid->leave_message('Leave message');
        $grid->critical_contact_phone('Critical contact phone');
        $grid->image('Image');
        $grid->order_code('Order code');
        $grid->send_name('Send name');
        $grid->send_content_phone('Send content phone');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(UserOrder::findOrFail($id));

        $show->id('Id');
        $show->user_id('User id');
        $show->user_address_id('User address id');
        $show->address('Address');
        $show->leave_message('Leave message');
        $show->critical_contact_phone('Critical contact phone');
        $show->image('Image');
        $show->order_code('Order code');
        $show->send_name('Send name');
        $show->send_content_phone('Send content phone');
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
        $form = new Form(new UserOrder);

        $form->number('user_id', 'User id');
        $form->number('user_address_id', 'User address id');
        $form->text('address', 'Address');
        $form->textarea('leave_message', 'Leave message');
        $form->textarea('critical_contact_phone', 'Critical contact phone');
        $form->image('image', 'Image');
        $form->text('order_code', 'Order code');
        $form->text('send_name', 'Send name');
        $form->text('send_content_phone', 'Send content phone');

        return $form;
    }
}
