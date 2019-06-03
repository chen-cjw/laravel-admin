<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps= false;

    protected $table = 'lab_customer';
    protected $fillable = [
        'code','name','openid','contactor','tel','email','address','receivables',
        'fax','update_time','create_time','is_delete'
    ];

    public function consignmentSample()
    {
        return $this->hasMany(ConsignmentSample::class,'customer_id','id');
    }

    public function consignmentReport()
    {
        return $this->hasMany(ConsignmentReport::class,'customer_id','id');
    }

    public function consignmentCheckitem()
    {
        return $this->hasMany(ConsignmentCheckitem::class,'customer_id','id');
    }
}
