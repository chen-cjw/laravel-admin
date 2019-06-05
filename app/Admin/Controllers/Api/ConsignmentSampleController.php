<?php

namespace App\Admin\Controllers\Api;

use App\Admin\Controllers\Controller;
use App\Models\ConsignmentCheckitem;
use App\Models\ConsignmentReport;
use App\Models\ConsignmentSample;
use App\Models\Customer;
use DB;
use Mockery\Exception;

class ConsignmentSampleController extends Controller
{
    public function addSampleOrder( )
    {
        //customer_name ,tel,car_no,openid
        $consignmentSample = \request()->only([ 'car_no','sample_name','productor']);
        $addCustomerData = \request()->only(['customer_name','openid' ,'tel','address']);
        $customer = Customer::where('tel',\request()->tel)->first();
        DB::beginTransaction();
        try{
            if(!$customer) {
                $customer = Customer::create($addCustomerData);
            }else{
                Customer::where('id',$customer->id)->update($addCustomerData);
            }

            $sample =  $this->addSample($consignmentSample,$customer);
            $sample_id = $sample->id;

            $this->addCheckitem($sample_id);
            $this->addReport($sample);

        }catch (Exception $ex){
            DB::rollBack();
        }

        DB::commit();
        return ['code'=>200,'message'=>'新增记录成功','data'=>array('sample_code'=>$sample->code)];
    }


    private function addSample($consignmentSample,$customer){
        $sample_data = array();

        $sample_data['code'] = $this->get_sample_code();
        $sample_data['name'] = $consignmentSample['sample_name'];
        $sample_data['car_no'] = $consignmentSample['car_no'];
        $sample_data['productor'] = $consignmentSample['productor'];

        $sample_data['spec'] = "袋";

        $sample_data['customer_id'] = $customer['id'];
        $sample_data['customer_name'] = $customer['name'];

        $sample =  ConsignmentSample::create($sample_data);
        return $sample;
    }

    private function addCheckitem($sample_id){

        $check_item_data = array();
        $check_item_data['sample_id'] = $sample_id;
        $check_item_data['name'] = "恩诺沙星（以恩诺沙星与环丙沙星之和计）";
        $check_item_data['unit'] = "ug/kg";
        $check_item_data['tech_req'] = "100";
        $check_item_data['test_value'] = "未检出";
        $check_item_data['test_method'] = "GB/T20366-2006";
        $check_item_data['item_conclusion'] = "合格";
        ConsignmentCheckitem::create($check_item_data);

        $check_item_data = array();
        $check_item_data['sample_id'] = $sample_id;
        $check_item_data['name'] = "氧氟沙星";
        $check_item_data['unit'] = "ug/kg";
        $check_item_data['tech_req'] = "1";
        $check_item_data['test_value'] = "未检出";
        $check_item_data['test_method'] = "GB/T20366-2006";
        $check_item_data['item_conclusion'] = "合格";
        ConsignmentCheckitem::create($check_item_data);

        $check_item_data = array();
        $check_item_data['sample_id'] = $sample_id;
        $check_item_data['name'] = "培氟沙星";
        $check_item_data['unit'] = "ug/kg";
        $check_item_data['tech_req'] = "1";
        $check_item_data['test_value'] = "未检出";
        $check_item_data['test_method'] = "GB/T20366-2006";
        $check_item_data['item_conclusion'] = "合格";
        ConsignmentCheckitem::create($check_item_data);

        $check_item_data = array();
        $check_item_data['sample_id'] = $sample_id;
        $check_item_data['name'] = "洛美沙星";
        $check_item_data['unit'] = "ug/kg";
        $check_item_data['tech_req'] = "1";
        $check_item_data['test_value'] = "未检出";
        $check_item_data['test_method'] = "GB/T20366-2006";
        $check_item_data['item_conclusion'] = "合格";
        ConsignmentCheckitem::create($check_item_data);

        $check_item_data = array();
        $check_item_data['sample_id'] = $sample_id;
        $check_item_data['name'] = "诺氟沙星";
        $check_item_data['unit'] = "ug/kg";
        $check_item_data['tech_req'] = "1";
        $check_item_data['test_value'] = "未检出";
        $check_item_data['test_method'] = "GB/T20366-2006";
        $check_item_data['item_conclusion'] = "合格";
        ConsignmentCheckitem::create($check_item_data);
    }

    private function addReport($sample){

        $report_data = array();
        $report_data['sample_code'] = $sample->code;
        $report_data['sample_id'] = $sample->id;
        $report_data['test_result'] = "产品所检项目符合农业部公告第 235 号的要求。";
        $report_data['test_standard'] = "GB/T 20366-2006 动物源产品中喹诺酮类残留量的测定 液相色谱-串联质谱法";

        ConsignmentReport::create($report_data);
    }

    private function get_sample_code(){

        $total=ConsignmentSample::where("is_delete",1)->where("create_time",">",strtotime(date('Y-m-d', time())))->count();

        $total = $total + 1;
        $total = str_pad($total,3,"0",STR_PAD_LEFT);
        $year = date('y');
        $month = date('m');
        $day = date('d');

        return "YP" . $year . $month . $day . $total;

    }

    public function makeCode()
    {
        $configModal = new SystemConfig();
        $qianZhui = $configModal->getItem('sample_number');

        if ($qianZhui && is_array($qianZhui)) {
            $qianZhui = $qianZhui[0] ?? '';
        }

        $total = self::where('create_time', '>=', strtotime(date('Y-m-d', time())))->count();

        $total = $total + 1;
        if ($total >= 10) {
            $subFix = $total;
        } else {
            $subFix = str_repeat('0', 2 - strlen($total)) . $total;
        }

        $year = date('y');
        $month = date('m');
        $day = date('d');

        return $qianZhui . $year . '-' . $month . '-' . $day . '-' . $subFix;
    }
}
