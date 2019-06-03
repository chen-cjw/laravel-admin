<?php

namespace App\Admin\Controllers\Admin;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CustomerController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Customer);

        $grid->id('Id');
        $grid->code('Code');
        $grid->name('Name');
        $grid->openid('Openid');
        $grid->contactor('Contactor');
        $grid->tel('Tel');
        $grid->email('Email');
        $grid->address('Address');
        $grid->receivables('Receivables');
        $grid->fax('Fax');
        $grid->update_time('Update time');
        $grid->create_time('Create time');
        $grid->is_delete('Is delete');

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
        $show = new Show(Customer::findOrFail($id));

        $show->id('Id');
        $show->code('Code');
        $show->name('Name');
        $show->openid('Openid');
        $show->contactor('Contactor');
        $show->tel('Tel');
        $show->email('Email');
        $show->address('Address');
        $show->receivables('Receivables');
        $show->fax('Fax');
        $show->update_time('Update time');
        $show->create_time('Create time');
        $show->is_delete('Is delete');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Customer);

        $form->text('code', 'Code');
        $form->text('name', 'Name');
        $form->text('openid', 'Openid');
        $form->text('contactor', 'Contactor');
        $form->text('tel', 'Tel');
        $form->email('email', 'Email');
        $form->text('address', 'Address');
        $form->decimal('receivables', 'Receivables')->default(0.00);
        $form->text('fax', 'Fax');
        $form->number('update_time', 'Update time');
        $form->number('create_time', 'Create time');
        $form->switch('is_delete', 'Is delete');

        return $form;
    }
}
