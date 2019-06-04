<?php

namespace App\Model2s;

use Illuminate\Database\Eloquent\Model;

class CustomerSendhis extends Model
{
    public $timestamps= false;

    protected $connection = 'mysql2';
    protected $table = 'lab_customer_sendhis';
    protected $fillable = [
        'code','name','openid','send_time','is_send','create_time'
    ];
}
