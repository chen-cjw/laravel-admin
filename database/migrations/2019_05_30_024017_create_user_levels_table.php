<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('等级名称');
            $table->unsignedInteger('level')->comment('用户等级');
            $table->decimal('point')->comment('达到的积分等级');
            $table->decimal('several_fold')->comment('几折');
            $table->unsignedInteger('address_max_number')->comment('用户创建地址的最大数量');

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
        Schema::dropIfExists('user_levels');
    }
}
