<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Models\ConsignmentReport;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use PhpOffice\PhpWord\PhpWord;

class ConsignmentReportController extends Controller
{
    use HasResourceActions;

    public function __construct()
    {
        $this->header = '检测项目';
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
        $grid->id('ID')->sortable();
        $grid->test_result('检验结论')->editable();
        $grid->test_standard('检验依据')->editable();
        $grid->remark('结论')->editable();
        $grid->disableActions(); // 禁用行操作列

        // 查询过滤
        $grid->filter(function($filter){

            // 在这里添加字段过滤器
            $filter->like('sample_id', '报告编制ID');

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

    public function download(){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $text = $section->addText('name');
        $text = $section->addText('email');
        $text = $section->addText('number',array('name'=>'Arial','size' => 20,'bold' => true));
        $section->addImage("http://img.keketour.comme/M00/00/06/CeT6ddHtg142.jpg");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Appdividend.docx');
        var_dump(public_path('Appdividend.docx'));

        return response()->download(public_path('Appdividend.docx'));

    }
}
