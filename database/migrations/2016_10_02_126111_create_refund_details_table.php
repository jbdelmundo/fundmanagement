<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaction_id');
            $table->unsignedInteger('request_id');
            $table->decimal('amount',12,2);
            $table->string('remarks');
           

            $table->foreign('transaction_id')
                ->references('id')->on('account_transactions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('request_id')
                ->references('id')->on('requests')
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
        Schema::dropIfExists('refund_details');
    }
}
