<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnroleeStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolee_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aysem');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('undergraduate');
            $table->unsignedInteger('graduate');

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('enrolee_statistics');
    }
}
