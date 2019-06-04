<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Admin\TimestampBetween;
use App\Models\ConsignmentReport;
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
     * create_time[start]=2019-03-04 00:00:00&create_time[end]=2019-06-26 00:00:00
     * 时间筛选条件 默认显示当天 或 未打印的报告  数据
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
            return $is_print==1 ? '<button type="button" class="btn btn-info btn-xs">是</button>' : '<button type="button" class="btn btn-warning btn-xs">否</button>';
        })->style('max-width:50px;word-break:break-all;');
        $grid->report()->is_send('是否通知')->display(function ($is_send) {
            return $is_send==1 ? '<button type="button" class="btn btn-primary btn-xs">是</button>' : '<button type="button" class="btn btn-danger btn-xs">否</button>';
            return $is_send==1 ? '是' : '否';
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
        $grid->message_comment('消息提醒')->display(function () {
            if($this->report) {
                return view('update_is_send',["report_id"=>$this->report['id']]);
            }
            return admin_toastr('消息提醒失败,关系错了！', 'error') ;
        });
        $grid->comment('操作')->display(function () {
            return "<a href="."/admin/consignment_checkitem?sample_id=".$this->id.">检测项目</a>";
//                .view('update_is_send',['report_id'=>$this->report->id]);
//                ."<div style='width: 20px'></div><a href="."/admin/consignment_report/sendMsg?sample_id=".$this->id.">消息提醒</a>";
        });

        // 查询过滤
        $grid->filter(function($filter){
            // 在这里添加字段过滤器
            $filter->column(1/2, function ($filter) {
                $filter->like('code', '样品编号');
                $filter->like('name', '样品名称');
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('customer_name', '客户名称');
                $filter->where(function ($query) {
                    $input = $this->input;
                    $query->whereHas('report', function ($query) use ($input) {
                        $query->where('is_print');
                    });
                }, '是否打印')->select(['否','是'])->default('否');
                $filter->use(new TimestampBetween('create_time','提交时间'))->datetime();

            });

        });
        //id   样品编号 样品名称  客户名称   是否打印   是否发送模板消息   检验结论  检验依据
        $grid->tools(function (Grid\Tools $tools){

            $tools->append("<a class='btn btn-warning btn-sm' href="."/admin/consignment_sample?create_time[start]=".date('Y-m-d 00:00:00').">
                                    筛选当天报告数据
                                 </a>");
        });


//          头部添加搜索按钮
//        $grid->header(function ($query) {
//            return "<a class='btn btn-primary' href="."/admin/consignment_sample?create_time[start]=".date('Y-m-d 00:00:00').">当天/未打印</a>";
//        });

        return $grid;
    }
    
    // 点击消息提醒 is_send 变成 是
    public function updateReportIsSend()
    {
        $reportId = request()->report_id;
        //dd($reportId);
        ConsignmentReport::where('id',$reportId)->update(['is_send'=>1]);

        admin_toastr('消息发送成功！', 'success');
        return back();
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
