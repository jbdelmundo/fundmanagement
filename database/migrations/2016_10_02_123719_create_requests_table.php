<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aysem');
            $table->unsignedInteger('department_id');
            $table->decimal('unit_quote_price',12,2);
            $table->integer('quantity');
            $table->integer('reserve_quantity');
            $table->string('remarks');
            $table->string('recommendedby');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('item_id');

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
        Schema::dropIfExists('requests');
    }
}
