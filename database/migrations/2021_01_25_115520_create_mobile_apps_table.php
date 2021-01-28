<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_apps', function (Blueprint $table) {
            $table->id();
            $table->integer('device_id');
            $table->string('device_OS');
            $table->string('app_name');
            $table->string('client_token');
            $table->boolean('in_app_purchase');
            $table->dateTime('register_time');
            $table->dateTime('subscription_start')->nullable();
            $table->dateTime('subscription_expire')->nullable();
            $table->integer('subscription_renewal')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_apps');
    }
}
