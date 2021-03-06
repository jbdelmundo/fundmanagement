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
	Schema::defaultStringLength(191);
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aysem');
            $table->unsignedInteger('department_id');
            $table->decimal('unit_quote_price',12,2);
            $table->decimal('total_quote_price',12,2)->nullable();
            $table->decimal('total_bid_price',12,2)->nullable();            
            $table->string('remarks')->nullable();
            $table->string('reject_reason')->nullable();
            $table->string('recommendedby')->nullable();
            
            $table->unsignedInteger('status')->default(0);
            $table->string('pr_number')->nullable();

            $table->string('category_id',1);
            $table->unsignedInteger('item_id')->nullable();
            
            
            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onUpdate('cascade');

            $table->foreign('status')
                ->references('id')->on('request_statuses')
                ->onUpdate('cascade');

            $table->foreign('aysem')
                ->references('aysem')->on('aysems')
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
