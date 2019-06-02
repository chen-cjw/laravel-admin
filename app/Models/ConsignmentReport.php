<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentReport extends Model
{
    protected $table = 'lab_consignment_report';
    protected $fillable = [
        'sample_id','sample_code','is_print','is_send','test_result','test_standard',
        'is_close','remark','update_time','create_time','file_url'
    ];
}
