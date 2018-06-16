<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNotificationSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notification_subscriptions', function (Blueprint $table) {

            $table->unsignedInteger('module_id');
            $table->unsignedInteger('user_id');

            $table->foreign('module_id')
                ->references('id')->on('modules')
                ->onUpdate('cascade');
           $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('user_notification_subscriptions');
    }
}
