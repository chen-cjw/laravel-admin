<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('商品名称');
            $table->text('description')->comment('商品详情');
            $table->string('image')->comment('商品封面图片文件路径');
            $table->boolean('on_sale')->comment('商品是否正在售卖')->default(true);
            $table->unsignedInteger('sold_count')->comment('销量');
            $table->decimal('price')->comment('价格');
            $table->string('stock')->comment('库存');
            $table->string('sort')->comment('权重(排序)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
