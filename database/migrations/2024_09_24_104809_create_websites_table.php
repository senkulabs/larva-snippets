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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->integer('GlobalRank');
            $table->integer('TldRank');
            $table->string('Domain');
            $table->string('TLD');
            $table->integer('RefSubNets');
            $table->integer('RefIPs');
            $table->string('IDN_Domain');
            $table->string('IDN_TLD');
            $table->integer('PrevGlobalRank');
            $table->integer('PrevTldRank');
            $table->integer('PrevRefSubNets');
            $table->integer('PrevRefIPs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
