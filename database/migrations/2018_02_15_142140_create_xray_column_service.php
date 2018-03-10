<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXrayColumnService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function($table){
            $table->integer('is_xray')->default(0);
        });
        Schema::table('lab_results', function($table){
            $table->string('file_no')->nullable();
            $table->integer('is_done')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function($table){
            $table->dropColumn('is_xray');
        });
        Schema::table('lab_results', function($table){
            $table->dropColumn('file_no');
            $table->dropColumn('is_done');
        });
    }
}
