<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_report', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id')->nullable();
            $table->string('city_name');
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->string('weather_description')->nullable();
            $table->string('weather_icon')->nullable();
            $table->double('temperature')->nullable();
            $table->double('min_temperature')->nullable();
            $table->double('max_temperature')->nullable();
            $table->double('pressure')->nullable();
            $table->double('humidity')->nullable();
            $table->double('sea_level')->nullable();
            $table->double('grnd_level')->nullable();
            $table->string('country')->nullable();
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
        Schema::dropIfExists('weather_report');
    }
};