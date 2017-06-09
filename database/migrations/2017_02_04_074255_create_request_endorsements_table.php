<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_endorsements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->unsigned();
            $table->integer('quantity')->default(1);
            $table->string('subject')->nullable();
            $table->integer('is_reserved')->default(0);
            
            

            $table->integer('endorsed_by')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('request_id')
                ->references('id')->on('requests')
                ->onUpdate('cascade');

            $table->foreign('endorsed_by')
                ->references('id')->on('users')
                ->onUpdate('cascade');
                
            $table->foreign('approved_by')
                ->references('id')->on('users')
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
        Schema::dropIfExists('request_approvals');
    }
}
