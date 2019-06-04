<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Admin\TimestampBetween;
use App\Model2s\CustomerSendhis;
use App\Models\ConsignmentReport;
use App\Models\ConsignmentSample;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use DB;

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
            if($this->report) {
                return view('download', ["report_id" => $this->report['id']]);
            }
        });
        $grid->message_comment('消息提醒')->display(function () {
            if($this->report['is_send'] == 1) {
                return '<button type="button" class="btn btn-warning btn-xs">已通知</button>';
            }
            if($this->report) {
                return view('update_is_send',["report_id"=>$this->report['id'],'id'=>$this->id]);
            }
            //return admin_toastr('消息提醒失败,关系错了！', 'error') ;
        });
        $grid->comment('操作')->display(function () {
            return "<a href="."/admin/consignment_checkitem?sample_id=".$this->id.">检测项目</a>";
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

        //  批量操作
        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
//                $actions->disableDelete();
            });
        });

        // 头部按钮
        $grid->tools(function (Grid\Tools $tools){

            $tools->append("<a class='btn btn-warning btn-sm' href="."/admin/consignment_sample?create_time[start]=".date('Y-m-d 00:00:00').">
                                    筛选当天报告数据
                                 </a>");
        });

        return $grid;
    }
    
    // todo *(加事物) 点击消息提醒 is_send 变成 是 || 连接到了其他数据库
    public function updateReportIsSend()
    {
        $reportId = request()->report_id;
        $sampleId = request()->sample_id;
        DB::beginTransaction();
        try {
            // 修改状态

            $consignmentSample = ConsignmentSample::find($sampleId);
            // 到另外一个数据，发送消息用
            $customerSendhisRes = CustomerSendhis::create([
                'code'=>$consignmentSample['code'],
                'name'=>$consignmentSample['name'],
                //'openid'=>$consignmentSample->consignment->openid,
                'create_time'=>time(),
            ]);
            ConsignmentReport::where('id',$reportId)->update(['is_send'=>1]);

            DB::commit();
            admin_toastr('ID是'.$sampleId.'的，消息发送成功！', 'success');
            return redirect('/admin/consignment_sample');
        } catch (\Exception $ex) {
            DB::rollback();
            \Log::error('消息发送失败', ['msg' => $ex->getMessage()]);
        }
    }
    
}
