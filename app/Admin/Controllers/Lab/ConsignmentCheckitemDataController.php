<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Admin\TimestampBetween;
use App\Models\ConsignmentCheckitemData;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ConsignmentCheckitemDataController extends Controller
{
    use HasResourceActions;
    public function __construct()
    {
        $this->header = '项目数据';
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ConsignmentCheckitemData);
        $grid->model()->orderBy('id','desc');
        $grid->id('ID')->sortable();
        //$grid->lab_id('Lab id');
        $grid->cate1('Cate1');
        //$grid->cate2('Cate2');
        //$grid->cate3('Cate3');
        //$grid->cate4('Cate4');
        //$grid->risk_level('Risk level');
        $grid->itemname('检测项目')->editable();
        $grid->standard_name('判定依据')->editable();
        $grid->test_method('Test method')->editable();
        $grid->determine_basis('检测依据')->editable();
        $grid->loq('定量限')->display(function ($loq) {
            return $loq.$this->loq_unit;
        });
        //$grid->q_type('Q type');
        $grid->max_limit('最大限')->display(function ($max_limit) {
            return $max_limit.$this->max_unit;
        });
        $grid->min_limit('最小限')->display(function ($max_limit) {
            return $max_limit.$this->max_unit;
        });
        $grid->remark('Remark');
        // 操作按钮
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });

        // 查询过滤
        $grid->filter(function($filter){
            $filter->column(1/2, function ($filter) {
                $filter->like('itemname', '检测项目');
                $filter->like('Cate1', 'Cate1');
                $filter->like('determine_basis', '检测依据');

            });
            $filter->column(1/2, function ($filter) {
                $filter->like('standard_name', '判定依据');
                $filter->like('test_method', 'test_method');
                $filter->use(new TimestampBetween('create_time','创建时间'))->datetime();
            });


        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ConsignmentCheckitemData);

        $form->number('lab_id', 'Lab id');
        $form->text('cate1', 'Cate1');
        $form->text('cate2', 'Cate2');
        $form->text('cate3', 'Cate3');
        $form->text('cate4', 'Cate4');
        $form->text('risk_level', 'Risk level');
        $form->text('itemname', '检测项目');
        $form->text('standard_name', '判定依据');
        $form->text('test_method', 'Test method');
        $form->text('determine_basis', '检测依据');
        $form->text('loq', '定量限（检出限）');
        $form->text('loq_unit', '定量限（检出限）单位');
        $form->text('q_type', '备注（限量属性）');
        $form->text('max_limit', '最大限');
        $form->text('max_unit', '最大限单位');
        $form->text('min_limit', '最小限');
        $form->text('min_unit', '最小限单位');
        $form->text('remark', '备注');

        return $form;
    }
}
