<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabResultItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_result_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lab_result_id')->unsigned();
            $table->string('name');
            $table->string('group')->nullable();
            $table->string('normal_values')->nullable();
            $table->string('co_values')->nullable();
            $table->string('result')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('lab_result_id')->references('id')->on('lab_results');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_result_items');
    }
}
