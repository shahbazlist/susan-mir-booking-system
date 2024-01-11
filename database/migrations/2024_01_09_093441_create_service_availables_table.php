<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAvailablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_availables', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->date('from_date')->nullable();
            $table->smallInteger('booked_slot')->default(0);
            $table->smallInteger('updated_max_slot')->default(0);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('service_availables');
    }
}
