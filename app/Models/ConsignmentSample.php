<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentSample extends Model
{
    protected $table = 'lab_consignment_sample';

    protected $fillable = [
        'code','name','spec','num','unit','productor','car_no',
        'customer_id','customer_name','is_delete','remark','update_time','create_time'
    ];

    public function report()
    {
        return $this->hasOne(ConsignmentReport::class,'sample_id','id');
    }
}
