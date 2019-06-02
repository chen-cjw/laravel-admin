<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('该订单所属的用户');
            $table->unsignedInteger('user_address_id')->comment('该用户的地址');
            $table->string('address')->comment('地址');
            $table->text('leave_message')->comment('留言'); // csrf 没做
            $table->text('critical_contact_phone')->comment('紧急联系电话'); // csrf 没做
            //
            $table->string('image')->comment('发送货物拍照');
            $table->string('order_code')->comment('订单号');
            $table->string('send_name')->comment('发货人');
            $table->string('send_content_phone')->comment('发货人联系方式');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('user_orders');
    }
}
