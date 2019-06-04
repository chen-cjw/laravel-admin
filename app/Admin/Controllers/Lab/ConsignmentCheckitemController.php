<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Admin\TimestampBetween;
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

        $grid->disableActions(); // 禁用行操作列
        $grid->disableCreateButton();

        $grid->id('ID')->sortable();
        $grid->name('项目名称')->style('max-width:80px;word-break:break-all;');
        $grid->unit('样品单位')->style('max-width:100px;word-break:break-all;');
        $grid->tech_req('技术要求')->editable()->style('max-width:150px;word-break:break-all;');
        $grid->test_value('检验结果')->editable()->style('max-width:150px;word-break:break-all;');
        $grid->test_method('检测方法')->editable()->style('max-width:150px;word-break:break-all;');
        $grid->create_time('添加时间')->display(function($create_time) {
            return date('Y-m-d H:i',$create_time);
        })->style('max-width:100px;word-break:break-all;')->sortable();
        $grid->update_time('修改时间')->display(function($update_time) {
                return date('Y-m-d H:i',$update_time);
            })->style('max-width:100px;word-break:break-all;')->sortable();

        // 查询过滤
        $grid->filter(function($filter){

            // 在这里添加字段过滤器
            $filter->like('name', '检测项目名称');
            $filter->like('sample_id', '样品ID');
            $filter->use(new TimestampBetween('create_time','创建时间'))->datetime();

        });

        // 表单右上角
        $grid->disableExport();
        //  批量操作
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
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
