<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_return_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_return_id')->unsigned();
            $table->integer('supply_id')->unsigned();
            $table->integer('quantity')->default(0);
            $table->string('lot_number')->nullable();
            $table->date('date_expired')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('inventory_return_id')->references('id')->on('inventory_returns');
            $table->foreign('supply_id')->references('id')->on('supplies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_return_items');
    }
}
