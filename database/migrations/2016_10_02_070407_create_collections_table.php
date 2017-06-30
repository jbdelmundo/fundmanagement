<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::defaultStringLength(191);
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('aysem');
            $table->decimal('amount',12,2);

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
        Schema::dropIfExists('collections');
    }
}
