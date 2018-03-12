<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXrayResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xray_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('lab_result_id')->unsigned();
            $table->string('file_no')->nullable();
            $table->date('date')->nullable();
            $table->string('clinical_data')->nullable();
            $table->text('remarks')->nullable();
            $table->text('impression')->nullable();
            $table->integer('is_done')->default(0);
            $table->integer('prepared_id')->unsigned();
            $table->integer('radiologist_id')->unsigned();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('lab_result_id')->references('id')->on('lab_results');

            $table->foreign('prepared_id')->references('id')->on('users');
            $table->foreign('radiologist_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xray_results');
    }
}
