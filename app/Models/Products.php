<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
        *$table->string('title')->comment('商品名称');
        *$table->text('description')->comment('商品详情');
        *$table->string('image')->comment('商品封面图片文件路径');
        *$table->boolean('on_sale')->comment('商品是否正在售卖')->default(true);
        *$table->unsignedInteger('sold_count')->comment('销量');
        *$table->decimal('price',[10,2])->comment('价格');
        *$table->string('stock')->comment('库存');
        *$table->string('sort')->comment('权重(排序)')
     **/


    protected $fillable = ['title','description','image','on_sale','sold_count','price','stock','sort'];
}
