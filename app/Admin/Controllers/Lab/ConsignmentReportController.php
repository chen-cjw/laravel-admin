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
        $section->addImage("http://pic-bucket.ws.126.net/photo/0003/2019-06-03/EGNSM9B400AJ0003NOS.jpg");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Appdividend.docx');


        return response()->download(public_path('Appdividend.docx'));

    }


    public function saveDoc($fileName, $data, $checkItem)
    {
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("/report_tpl/gaoyou01.docx");

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $templateProcessor->setValue('page_1', '第1页,共2页');
        $templateProcessor->setValue('page_2', '第2页,共2页');

        $templateProcessor->cloneRow('name', count($checkItem));

        for ($i = 1; $i <= count($checkItem); $i++) {
            $templateProcessor->setValue('index#' . $i,  $i);

            $templateProcessor->setValue('name#' . $i, $this->filter_check_item_name($checkItem[$i - 1]['name']));
            $templateProcessor->setValue('unit#' . $i, $checkItem[$i - 1]['unit']);
            $templateProcessor->setValue('standard#' . $i, $this->filter_string($checkItem[$i - 1]['standard_value']));
            $templateProcessor->setValue('method#' . $i, $this->filter_string($checkItem[$i - 1]['test_method']));
            $templateProcessor->setValue('text#' . $i, $checkItem[$i - 1]['item_conclusion']);
            $result1 = "";
            $result2 = "";
            $result3="";
            $test_value =$checkItem[$i - 1]['test_value'];
            if (strstr($test_value, "^")) {
                if (count(explode("*",$test_value))) {
                    $result1 = explode("*",$test_value)[0];
                    $temp_result = explode("*",$test_value)[1];
                    if (count(explode("^",$temp_result))) {
                        $result2 = explode("^",$temp_result)[0];
                        $result3 = explode("^",$temp_result)[1];
                    }
                }

                $templateProcessor->setValue('result#' . $i, $this->filter_string(""));
                $templateProcessor->setValue('result1#' . $i, $this->filter_string($result1."×"));
                $templateProcessor->setValue('result2#' . $i, $this->filter_string($result2));
                $templateProcessor->setValue('result3#' . $i, $this->filter_string($result3));
            }else{
                $templateProcessor->setValue('result#' . $i, $this->filter_string($test_value));
                $templateProcessor->setValue('result1#' . $i, $this->filter_string($result1));
                $templateProcessor->setValue('result2#' . $i, $this->filter_string($result2));
                $templateProcessor->setValue('result3#' . $i, $this->filter_string($result3));
            }
        }

        $templateProcessor->saveAs($fileName);
    }
    /*
     * 过滤掉项目名中的【】 内容
     */
    public function filter_check_item_name($item_name)
    {
        $is_right =0;
        $a = strpos($item_name, "[");
        $b = strpos($item_name, "]");

        if ($a >= 0&&$b > $a) {
            $is_right =1;
        }else {
            $a = strpos($item_name, "【");
            $b = strpos($item_name, "】");
            if ($a >= 0 && $b > $a) {
                $is_right = 1;
            }
        }

        if($is_right){
            $length = $b - $a+1;
            $str = substr($item_name,$a,$length);
            $item_name = str_replace($str,"",$item_name);
        }

        return $item_name;
    }

    public function filter_string($replace)
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

    public function download2($id)
    {
        $report = ConsignmentReport::get($id);
        if (!$report) {
            throw new \Exception('报告不存在');
        }

        if (empty($report->test_result)||empty($report->test_standard)) {
            throw new \Exception('请先去完善报告结论等内容');
        }

        $order = ConsignmentOrder::get($report->order_id);
        $orderType = $order->order_type;

        $baseUrl = SOURCE_PATH . 'report/';
        $model = new SystemConfig();
        if ($orderType == 1) {
            $path = $model->getItem('report_template_01');
        } else if ($orderType == 2) {
            $path = $model->getItem('report_template_02');
        }

        if (!$path) {
            throw new \Exception('模版未配置');
        }

        $templateFile = $baseUrl . $path[0];
        if (!file_exists($templateFile)) {
            throw new \Exception('模版不存在');
        }


        $sample = ConsignmentOrderSample::get($report->order_sample_id);
        $standard = ConsignmentOrderStandardLib::where('order_sample_id', $report->order_sample_id)->find();
        $checkItem = ConsignmentOrderCheckItem::where('order_sample_id', $report->order_sample_id)->select();
        $checkItem = $checkItem ? $checkItem->toArray() : [];
        $time = time();

        $extra = $sample->extra ? json_decode($sample->extra, true) : [];


        $data = [
            'sample_name' => $sample->name,
            'customer_name' => $order->customer_name,
            'report_date' => $this->getDate($time),
            'sample_code' => $sample->code,
            'sample_spec' => $sample->spec,
            'product_date' => $sample->product_date,
            'customer_address' => $order->address,
            'appear' => $sample->appear,
            'number' => $sample->num . $sample->unit,
            'standard_code' => $standard ? $standard->code : '——',
            'standard_name' => $standard ? $standard->name : '——',
            'report_result' => $report->test_result,
            'report_time' => $this->getDate($time,false),
            'create_time' => $this->getDate($order->order_date,false),
            'end_time' => $this->getDate(strtotime($report->create_time),false),
            'year' => date('Y', time()),
            'brand' => $sample->brand_name ? $sample->brand_name : '——',
            'level' => $sample->product_level ? $sample->product_level : '——',
            'product_address' => $sample->product_address,
            'receive' => $sample->recevie_date ? date('Y.m.d', $sample->recevie_date) : '——',
            'productor' => $sample->productor,
            'report_code' => $report->code,
        ];


        if ($orderType == 2) {

            $checkItems = array_map(function ($item) {
                return $item['name'];
            }, $checkItem);

            $data['check_items'] = implode(',', $checkItems);
            $data['y'] = date('Y');
            $data['m'] = date('m');
            $data['d'] = date('d');
        }


        $fileName = $sample->code . '.docx';
        $filePath = WEB_PATH . 'download/' . $fileName;

        $this->saveDoc($filePath, $data, $checkItem, $templateFile);

        return response()->download(public_path('Appdividend.docx'));
        return $fileName;

    }

    public function getDate($time,$is_convert_num=true)
    {
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);
        $yearString = '';
        if($is_convert_num){

            for ($i = 0; $i < strlen($year); $i++) {
                $yearString .= $this->getNumber($year[$i]);
            }

            $month = $this->getNumber($month);
            $day = $this->getNumber($day);
        }else{
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



    protected function sendMsg(){
        //存入数据到待发送记录表

    }
}
