<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Models\ConsignmentSample;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ConsignmentSampleController extends Controller
{
    use HasResourceActions;

    public function __construct()
    {
        $this->header = '报告编制';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ConsignmentSample);
        $grid->id('ID')->sortable()->style('max-width:50px;word-break:break-all;');
        $grid->code('样品编号')->style('max-width:100px;word-break:break-all;');
        $grid->name('样品名称')->style('max-width:150px;word-break:break-all;');
        $grid->customer_name('客户名称')->style('max-width:150px;word-break:break-all;')->editable();
        $grid->report()->is_print('是否打印')->display(function ($is_print) {
            return $is_print ? '是' : '否';
        })->style('max-width:50px;word-break:break-all;');
        $grid->report()->is_send('是否通知')->display(function ($is_send) {
            return $is_send ? '是' : '否';
        })->style('max-width:50px;word-break:break-all;');
        $grid->report()->test_result('检验结论')->style('max-width:150px;word-break:break-all;')->editable();
        $grid->report()->test_standard('检验依据')->style('max-width:150px;word-break:break-all;')->editable();
        $grid->create_time('提交时间')->display(function ($create_time) {
            return date('Y-m-d H:i',$create_time);
        })->style('max-width:90px;word-break:break-all;');

        $grid->disableActions(); // 禁用行操作列
        $grid->disableCreateButton();

        $grid->download('下载')->display(function () {
            return view('download',["report_id"=>52]);
        });
        $grid->comment('操作')->display(function () {
            return "<a href="."/admin/consignment_checkitem?sample_id=".$this->id.">检测项目</a>"
                ."<div style='width: 20px'></div><a href="."/admin/consignment_report/sendMsg?sample_id=".$this->id.">消息提醒</a>";
        });

        // 查询过滤
        $grid->filter(function($filter){
            // 在这里添加字段过滤器
            $filter->like('code', '样品编号');
            $filter->like('name', '样品名称');
            $filter->like('customer_name', '客户名称');

        });
        //id   样品编号 样品名称  客户名称   是否打印   是否发送模板消息   检验结论  检验依据
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
        $show = new Show(ConsignmentSample::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ConsignmentSample);



        return $form;
    }
}
