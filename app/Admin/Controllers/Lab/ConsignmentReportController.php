<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
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

    private function getDate($time, $is_convert_num = true)
    {
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);
        $yearString = '';
        if ($is_convert_num) {

            for ($i = 0; $i < strlen($year); $i++) {
                $yearString .= $this->getNumber($year[$i]);
            }

            $month = $this->getNumber($month);
            $day = $this->getNumber($day);
        } else {
            $yearString = $year;
        }

        return $yearString . '年' . $month . '月' . $day . '日';
    }

    protected function getNumber($number)
    {
        switch ($number) {
            case 0:
                return '〇';
            case 1:
                return '一';
            case 2:
                return '二';
            case 3:
                return '三';
            case 4:
                return '四';
            case 5:
                return '五';
            case 6:
                return '六';
            case 7:
                return '七';
            case 8:
                return '八';
            case 9:
                return '九';
            case 10:
                return '十';
            case 11:
                return '十一';
            case 12:
                return '十二';
            case 13:
                return '十三';
            case 14:
                return '十四';
            case 15:
                return '十五';
            case 16:
                return '十六';
            case 17:
                return '十七';
            case 18:
                return '十八';
            case 19:
                return '十九';
            case 20:
                return '二十';
            case 21:
                return '二十一';
            case 22:
                return '二十二';
            case 23:
                return '二十三';
            case 24:
                return '二十四';
            case 25:
                return '二十五';
            case 26:
                return '二十六';
            case 27:
                return '二十七';
            case 28:
                return '二十八';
            case 29:
                return '二十九';
            case 30:
                return '三十';
            case 31:
                return '三十一';
        }
    }

    /*
     * 过滤掉项目名中的【】 内容
     */
    private function filter_check_item_name($item_name)
    {
        $is_right = 0;
        $a = strpos($item_name, "[");
        $b = strpos($item_name, "]");

        if ($a >= 0 && $b > $a) {
            $is_right = 1;
        } else {
            $a = strpos($item_name, "【");
            $b = strpos($item_name, "】");
            if ($a >= 0 && $b > $a) {
                $is_right = 1;
            }
        }

        if ($is_right) {
            $length = $b - $a + 1;
            $str = substr($item_name, $a, $length);
            $item_name = str_replace($str, "", $item_name);
        }

        return $item_name;
    }

    /*
     *
     */
    private function filter_string($replace)
    {
        if ($replace && strlen($replace) > 0) {
            $replace = str_replace('&', '&amp;', $replace);
            $replace = str_replace('<', '&lt;', $replace);
            $replace = str_replace('>', '&gt;', $replace);
            $replace = str_replace('\'', '&quot;', $replace);
            $replace = str_replace('"', '&apos;', $replace);
        }
        return $replace;
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
