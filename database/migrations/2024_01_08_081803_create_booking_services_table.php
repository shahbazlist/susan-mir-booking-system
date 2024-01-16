<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->integer('service_id');
            $table->integer('service_available_id');
            $table->string('full_name');
            $table->string('email');
            $table->string('booking_qty');
            $table->string('total_cost');
            $table->date('booking_service_date')->nullable();
            $table->dateTime('booking_date')->nullable();
            $table->time('service_from_time')->nullable();
            $table->time('service_to_time')->nullable();
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
        Schema::dropIfExists('booking_services');
    }
}
