<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('GlobalRank');
            $table->string('TldRank');
            $table->string('Domain');
            $table->string('TLD');
            $table->string('RefSubNets');
            $table->string('RefIPs');
            $table->string('IDN_Domain');
            $table->string('IDN_TLD');
            $table->string('PrevGlobalRank');
            $table->string('PrevTldRank');
            $table->string('PrevRefSubNets');
            $table->string('PrevRefIPs');
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
