<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::defaultStringLength(191);
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->unsigned();
            $table->string('title');
            $table->string('author');
            $table->string('edition');
            $table->string('copyright_date');
            $table->string('publisher');
            $table->string('isbn');
            $table->boolean('iselectronic');
            $table->timestamps();

            $table->foreign('request_id')
                ->references('id')->on('requests')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
