<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsagestatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usagestatistics', function(Blueprint $table){
           // id
           // eresource_id
           // request_id
           // department_id
           // status_id
           // month
           // year
           // usage
            $table->increments('id'); 
            $table->unsignedInteger('eresource_id');
            $table->unsignedInteger('request_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('status_id');
            $table->integer('month');
            $table->integer('year'); 
            $table->integer('usage');
           
           
            $table->foreign('eresource_id')
                ->references('id')->on('eresources')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('request_id')
                ->references('id')->on('requests')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('status_id')
                ->references('id')->on('request_statuses')
                ->onUpdate('cascade')
                ->onDelete('cascade');



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
        Schema::dropIfExists('usagestatistics');
    }
}
