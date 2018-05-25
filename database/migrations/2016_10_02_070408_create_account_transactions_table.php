<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::defaultStringLength(191);
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_account_transaction_id')->nullable();
            $table->unsignedInteger('aysem');           
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('request_id')->nullable();
            $table->unsignedInteger('collection_id')->nullable();
            $table->char('transaction_type_id',1);
            $table->decimal('amount',12,2);
            $table->decimal('balance',12,2);

            
            $table->string('remarks')->nullable();
            $table->unsignedInteger('transaction_details_id')->nullable();

            $table->foreign('parent_account_transaction_id')
                ->references('id')->on('account_transactions')
                ->onUpdate('cascade');

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onUpdate('cascade');

            $table->foreign('transaction_type_id')
                ->references('id')->on('transaction_types')
                ->onUpdate('cascade');
            
            $table->foreign('request_id')
                ->references('id')->on('requests')
                ->onUpdate('cascade');

            $table->foreign('collection_id')
                ->references('id')->on('collections')
                ->onUpdate('cascade');

            $table->foreign('aysem')
                ->references('aysem')->on('aysems')
                ->onUpdate('cascade');

            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_transactions');
    }
}
