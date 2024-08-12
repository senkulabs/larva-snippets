<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bike_share', function (Blueprint $table) {
            $table->id();
            $table->integer('duration');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('start_station_number');
            $table->string('start_station');
            $table->integer('end_station_number');
            $table->string('end_station');
            $table->string('bike_number');
            $table->string('member_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_share');
    }
};
