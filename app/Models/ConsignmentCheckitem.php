<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentCheckitem extends Model
{
    public $timestamps= false;
    protected $table = 'lab_consignment_checkitem';
    protected $fillable = [
        'name','unit','tech_req','test_value','test_method','orgs',
        'user_id','user_name','remark','update_time','create_time','sample_id'
    ];

    public function addAll(Array $data)
    {
        $rs = DB::table($this->getTable())->insert($data);
        return $rs;
    }
}
