<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsignmentReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        protected $fillable = [
//        'sample_id','sample_code','is_print','is_send','test_result','test_standard',
//        'is_close','remark','update_time','create_time','file_url'
//    ];
        Schema::create('consignment_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sample_id');
            $table->string('sample_code');
            $table->string('is_print');
            $table->integer('is_send'); // bool
            $table->string('test_result');
            $table->string('test_standard');
            $table->string('is_close');
            $table->string('remark');
            $table->string('update_time');
            $table->string('create_time');
            $table->string('file_url');

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
        Schema::dropIfExists('consignment_reports');
    }
}
