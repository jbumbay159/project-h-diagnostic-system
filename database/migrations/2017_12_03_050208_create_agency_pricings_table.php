<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_pricings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id')->unsigned();
            $table->integer('agency_id')->unsigned();
            $table->integer('pricing_type_id')->unsigned();
            $table->decimal('price', 15, 2);
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('agency_id')->references('id')->on('agencies');
            $table->foreign('pricing_type_id')->references('id')->on('pricing_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_pricings');
    }
}
