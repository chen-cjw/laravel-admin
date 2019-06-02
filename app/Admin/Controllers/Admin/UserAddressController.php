<?php

namespace App\Admin\Controllers\Admin;

use App\Models\UserAddress;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserAddressController extends Controller
{
    use HasResourceActions;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserAddress);

        $grid->id('Id');
        $grid->user_id('User id');
        $grid->province('Province');
        $grid->city('City');
        $grid->district('District');
        $grid->address('Address');
        $grid->contact_name('Contact name');
        $grid->contact_phone('Contact phone');
        $grid->last_used_at('Last used at');
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
        $show = new Show(UserAddress::findOrFail($id));

        $show->id('Id');
        $show->user_id('User id');
        $show->province('Province');
        $show->city('City');
        $show->district('District');
        $show->address('Address');
        $show->contact_name('Contact name');
        $show->contact_phone('Contact phone');
        $show->last_used_at('Last used at');
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
        $form = new Form(new UserAddress);

        $form->number('user_id', 'User id');
        $form->text('province', 'Province');
        $form->text('city', 'City');
        $form->text('district', 'District');
        $form->text('address', 'Address');
        $form->text('contact_name', 'Contact name');
        $form->text('contact_phone', 'Contact phone');
        $form->text('last_used_at', 'Last used at');

        return $form;
    }
}
