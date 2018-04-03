<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabResultItemChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_result_item_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lab_result_item_id')->unsigned();
            $table->string('result')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('lab_result_item_id')->references('id')->on('lab_result_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_result_item_changes');
    }
}
