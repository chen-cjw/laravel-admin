<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Admin\TimestampBetween;
use App\Models\ConsignmentCheckitem;
use App\Models\ConsignmentReport;
use App\Models\ConsignmentSample;
use App\Models\Customer;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Request;

class CustomerController extends Controller
{
    use HasResourceActions;

    public function __construct()
    {
        $this->header = '客户管理';
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Customer);
        $grid->model()->where('is_delete',0)->orderBy('id','desc');
        $grid->id('ID')->sortable();
        $grid->code('客户编号');
        $grid->name('客户名称');
        $grid->contactor('联系人');
        $grid->tel('联系电话');
        $grid->email('邮箱');
        $grid->address('地址');
        $grid->receivables('应收账款数字');

        $grid->create_time('创建时间')->display(function ($create_time) {
            return date('Y-m-d H:i',$create_time);
        })->sortable();

        // 查询过滤
        $grid->filter(function($filter){
            $filter->column(1/2, function ($filter) {
                $filter->like('code', '客户编号');
                $filter->like('name', '客户名称');
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('contactor', '联系人');
                $filter->like('tel', '联系电话');
                $filter->use(new TimestampBetween('create_time','创建时间'))->datetime();
            });


        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Customer::findOrFail($id));

        $show->id('ID');
        $show->code('客户编号');
        $show->name('客户名称');
        $show->contactor('联系人');
        $show->tel('联系电话');
        $show->email('邮箱');
        $show->address('地址');
        $show->receivables('应收账款数字');
        $show->fax('传真');
        $show->is_delete('是否删除')->using(['否','是']);

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

        $form->text('code', '客户编号');
        $form->text('name', '客户名称');
//        $form->text('openid', '客户openid');
        $form->text('contactor', '联系人');
        $form->text('tel', '联系电话');
        $form->email('email', '邮箱');
        $form->text('address', '地址');
        $form->decimal('receivables', '应收账款数字')->default(0.00);
        $form->text('fax', '传真');
        $form->switch('is_delete', '是否删除');

        return $form;
    }
    public function index(Content $content)
    {
        return $content
            ->header($this->header)
            ->description('管理')
            ->body($this->grid());
    }

    // 1、新增记录接口
    public function addCustomerIndex(Content $content)
    {
        return $content
            ->header('新增记录接口')
            ->description('管理')
            ->body(view('customer'));
    }

}
