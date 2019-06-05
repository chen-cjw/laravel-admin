<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Admin\TimestampBetween;
use App\Models\ConsignmentCheckitem;
use App\Models\ConsignmentReport;
use App\Models\ConsignmentSample;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use http\Env\Request;
use PhpOffice\PhpWord\PhpWord;
use Barryvdh\Debugbar\Facade as Debugbar;

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

        $grid = new Grid(new ConsignmentReport);
        $grid->id('ID')->sortable();
        $grid->test_result('检验结论')->editable();
        $grid->test_standard('检验依据')->editable();
        $grid->remark('结论')->editable();
        $grid->disableActions(); // 禁用行操作列

        // 查询过滤
        $grid->filter(function ($filter) {

            // 在这里添加字段过滤器
            $filter->like('sample_id', '报告编制ID');
            $filter->use(new TimestampBetween('create_time','创建时间'))->datetime();

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

    public function download2()
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $text = $section->addText('name');
        $text = $section->addText('email');
        $text = $section->addText('number', array('name' => 'Arial', 'size' => 20, 'bold' => true));
        $section->addImage("http://pic-bucket.ws.126.net/photo/0003/2019-06-03/EGNSM9B400AJ0003NOS.jpg");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Appdividend.docx');

        return response()->download(public_path('Appdividend.docx'));
    }

    protected function sendMsg()
    {
        //存入数据到待发送记录表

    }

    public function download()
    {
        $report_id = \Request::post("report_id");
        $report = ConsignmentReport::find($report_id);
//        Debugbar::info($id);

        if (!$report) {
            admin_toastr('报告不存在', 'error');
        }

        if (empty($report->test_result) || empty($report->test_standard)) {
            admin_toastr('请先去完善报告结论等内容', 'error');
        }

        $sample = ConsignmentSample::find($report->sample_id);

//        $customer = Customer::find($sample->customer_id);

        $checkItems = ConsignmentCheckitem::where('sample_id', $report->sample_id)->get();

        $checkItems = $checkItems ? $checkItems->toArray() : [];

        $time = time();

        $data = [
            'samp_name' => $sample->name,

//            'customer_name' => $order->customer_name,
//            'customer_address' => $order->address,

            'report_date' => $this->getDate($time),
            'sample_code' => $sample->code,
            'samp_unit' => $sample->unit,
            'samp_carno' => $sample->car_no,
            'year' => date('Y', time()),

            'test_result' => $report->test_result,
            'test_standard' => $report->test_standard,

            'productor' => $sample->productor,
            'report_code' => $report->code,
        ];

        $fileName = $sample->code . '.docx';
        $filePath = 'download/' . $fileName;

        $this->saveDoc($filePath, $data, $checkItems);

        return response()->download(public_path($filePath));
    }


    private function saveDoc($fileName, $data, $checkItem)
    {
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("report_tpl/gaoyou01.docx");

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $templateProcessor->setValue('page_1', '第1页,共2页');
        $templateProcessor->setValue('page_2', '第2页,共2页');

        $templateProcessor->cloneRow('name', count($checkItem));

        for ($i = 1; $i <= count($checkItem); $i++) {
            $templateProcessor->setValue('in#' . $i, $i);

            $templateProcessor->setValue('cname#' . $i, $this->filter_check_item_name($checkItem[$i - 1]['name']));
            $templateProcessor->setValue('unit#' . $i, $checkItem[$i - 1]['unit']);
            $templateProcessor->setValue('tech_req#' . $i, $this->filter_string($checkItem[$i - 1]['tech_req']));
            $templateProcessor->setValue('test_value#' . $i, $this->filter_string($checkItem[$i - 1]['test_value']));
            $templateProcessor->setValue('method#' . $i, $this->filter_string($checkItem[$i - 1]['test_method']));
            $templateProcessor->setValue('text#' . $i, $checkItem[$i - 1]['item_conclusion']);
        }

        $templateProcessor->saveAs($fileName);
    }


}
