<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Models\ConsignmentCheckitem;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ConsignmentCheckitemController extends Controller
{
    use HasResourceActions;

    public function __construct()
    {
        $this->header = '检验项目';
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ConsignmentCheckitem);
        //项目名称(name) 样品单位(unit) 技术要求(tech_req) 检验结果(test_value) 检测方法(test_method) 添加时间(create_time)

        $grid->id('ID');
        $grid->name('项目名称');
        $grid->unit('样品单位');
        $grid->tech_req('技术要求');
        $grid->test_value('检验结果');
        $grid->test_method('检测方法');
        $grid->create_time('添加时间')->display(function($create_time) {
            return date('Y-m-d H:i:s',$create_time);
        });
        // 查询过滤
        $grid->filter(function($filter){

            // 在这里添加字段过滤器
            $filter->like('name', '项目名称');

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
        $show = new Show(ConsignmentCheckitem::findOrFail($id));

        $show->id('ID');
        $show->name('项目名称');
        $show->unit('样品单位');
        $show->tech_req('技术要求');
        $show->test_value('检验结果');
        $show->test_method('检测方法');
        $show->create_time('添加时间')->display(function($create_time) {
            return date('Y-m-d H:i:s',$create_time);
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ConsignmentCheckitem);

        $form->text('name', '项目名称');
        $form->text('unit', '样品单位');
        $form->text('tech_req', '技术要求');
        $form->text('test_value', '检验结果');
        $form->text('test_method', '检测方法');
        //$form->date('create_time', '添加时间');

        return $form;
    }
}
