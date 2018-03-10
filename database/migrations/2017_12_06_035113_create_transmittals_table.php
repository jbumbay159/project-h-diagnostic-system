<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransmittalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transmittals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned();
            $table->integer('agency_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->date('encode_date')->nullable();
            $table->integer('days')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('exp_diplay')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('agency_id')->references('id')->on('agencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transmittals');
    }
}
