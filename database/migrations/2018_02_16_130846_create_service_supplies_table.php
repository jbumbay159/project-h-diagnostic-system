<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_supplies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supply_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->integer('qty')->default(0);
            $table->timestamps();

            $table->foreign('supply_id')->references('id')->on('supplies');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_supplies');
    }
}
