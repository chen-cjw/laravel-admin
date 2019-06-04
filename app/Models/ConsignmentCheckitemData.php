<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentCheckitemData extends Model
{
    public $timestamps= false;

    protected $table = 'lab_consignment_checkitem_data';//数据表

    protected $fillable = [
        'lab_id','cate1','cate2','cate3','cate4','risk_level','itemname','standard_name',
        'test_method','determine_basis','loq','loq_unit','q_type','max_limit','max_unit','min_limit',
        'min_unit','remark'
    ];

}
