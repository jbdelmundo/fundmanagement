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
            $table->string('remarks')->nullable();
            $table->string('recommendedby')->nullable();
            $table->string('category_id',1);
            $table->unsignedInteger('status')->default(0);
            $table->string('pr_number')->nullable();
            $table->unsignedInteger('item_id')->nullable();

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onUpdate('cascade');

            $table->foreign('status')
                ->references('id')->on('request_statuses')
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
