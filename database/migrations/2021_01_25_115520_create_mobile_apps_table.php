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
            $table->string('name');
            $table->string('app_token');
            $table->boolean('in_app_purchase');
            $table->boolean('subscription_status')->default(0);
            $table->dateTime('register_time');
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
