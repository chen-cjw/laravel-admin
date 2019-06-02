<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Models\ConsignmentReport;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ConsignmentReportController extends Controller
{
    use HasResourceActions;

    public function __construct()
    {
        $this->header = '会员';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
//        protected $fillable = [
//        'sample_id','sample_code','is_print','is_send','test_result','test_standard',
//        'is_close','remark','update_time','create_time','file_url'
//    ];
        $grid = new Grid(new ConsignmentReport);
        $grid->id('编号')->sortable();
        $grid->name('用户名');


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
        $show = new Show(ConsignmentReport::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ConsignmentReport);



        return $form;
    }
}
