<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    use ModelTree,AdminBuilder;

    public $timestamps= false;

    protected $table = 'lab_org';//部门

    protected $fillable = [
        'org_name','parent_id','lab_id','remark','create_time','update_time','parent_name','order'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('order');
        $this->setTitleColumn('parent_name');
    }
}
