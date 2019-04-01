<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('passenger_id');
            $table->unsignedInteger('from_id');
            $table->unsignedInteger('to_id');
            $table->string('from_address');
            $table->string('to_address');
            $table->date('date');
            $table->time('time');
            $table->string('notes')->nullable();
            $table->enum('going', ['going', 'going_and_comingback', 'going_and_comingback_otherday']);
            $table->date('other_day')->nullable();
            $table->time('other_time')->nullable();
            $table->bigInteger('promo_code')->nullable();
            $table->string('price', 20);
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
        Schema::dropIfExists('trips');
    }
}
