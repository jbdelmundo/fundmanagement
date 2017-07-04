<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrolleeStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::defaultStringLength(191);
        Schema::create('enrollee_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aysem');
            $table->unsignedInteger('collection_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('undergraduate');
            $table->unsignedInteger('graduate');

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onUpdate('cascade');
            $table->foreign('collection_id')
                ->references('id')->on('collections')
                ->onUpdate('cascade');
            $table->timestamps();

            $table->foreign('aysem')
                ->references('aysem')->on('aysems')
                ->onUpdate('cascade');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrolee_statistics');
    }
}
