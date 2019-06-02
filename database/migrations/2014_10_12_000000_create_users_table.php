<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->nullable()->unique();
            $table->string('weapp_openid')->nullable()->unique();
            $table->string('weixin_session_key')->nullable();
            $table->string('password')->nullable();
            $table->decimal('point')->default(0);
//            $table->unsignedInteger('user_level_id')->comment('用户等级')->default(0);
            $table->timestamp('deleted_at')->nullable();

//            $table->foreign('user_level_id')->references('id')->on('user_levels')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
