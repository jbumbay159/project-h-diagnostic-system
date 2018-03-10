<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('sale_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->string('category_name');
            $table->string('name');
            $table->text('remarks')->nullable();
            $table->text('interpret')->nullable();
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('customer_id')->references('id')->on('customers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_results');
    }
}
