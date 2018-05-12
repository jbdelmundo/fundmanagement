<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::defaultStringLength(191);
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('initials');
            $table->string('short_name');
            $table->string('full_name');
            $table->boolean('is_from_book_fund')->default(true);
            $table->boolean('is_percent_based')->default(false);
            $table->decimal('percent_allocation',5,2)->nullable();
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
        Schema::dropIfExists('departments');
    }
}
